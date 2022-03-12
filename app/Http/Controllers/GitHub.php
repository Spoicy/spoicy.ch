<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GitHub extends Controller
{
    //

    public static function getFeed() {
        $feed = simplexml_load_file("https://github.com/spoicy.atom");
        return $feed;
    }

    public static function createEntry($data) {
        $entry = new \stdClass();
        $entry->title = (string) $data->title;
        $entry->link = (string) $data->link->attributes()->href;
        $entry->author = (string) $data->author->name;
        $date = new \DateTime((string) $data->published);
        $entry->datetime = $date->format("M j, Y");
        return $entry;
    }

    public static function callGitHubAPI($link) {
        $response = Http::withHeaders([
            'User-Agent' => 'request'
        ])->get("https://api.github.com/repos".explode("https://github.com", $link)[1]);
        $response = json_decode($response);
        return $response;
    }

    public static function processPush($data) {
        $entry = self::createEntry($data);
        $entry->type = "Push";
        $entry->repo = explode("/compare", explode("https://github.com/", $entry->link)[1])[0];
        $entry->branch = explode(" in", explode("pushed to ", $entry->title)[1])[0];
        $entry->commits = array();
        $commits = self::callGitHubAPI($entry->link);
        foreach ($commits->commits as $commit) {
            $commitEntry = new \stdClass();
            $commitEntry->id = substr($commit->sha, 0, 7);
            $commitEntry->link = $commit->html_url;
            $commitEntry->message = $commit->commit->message;
            $entry->commits[] = $commitEntry;
        }
        return $entry;
    }

    public static function processWatch($data) {
        $entry = self::createEntry($data);
        $entry->type = "Watch";
        $repo = self::callGitHubAPI($entry->link);
        $entry->repo = $repo->full_name;
        $entry->repodesc = $repo->description;
        $entry->lang = $repo->language;
        return $entry;
    }

    public static function processIssue($data) {
        $entry = self::createEntry($data);
        $entry->type = "Issue";
        $entry->repo = explode("/issues", explode("https://github.com/", $entry->link)[1])[0];
        $entry->issuetype = explode(" an", explode($entry->author . " ", $entry->title)[1])[0];
        $issue = self::callGitHubAPI($entry->link);
        $entry->issuename = $issue->title;
        $entry->issuenum = $issue->number;
        return $entry;
    }

    /**
     * Returns the variables required for the GitHub template.
     * 
     * @return array $variables
     */
    public static function variables() {
        $feed = self::getFeed();
        $githubThree = array();
        for ($i = 0; $i < 3; $i++) {
            $eventtype = explode("/", explode("tag:github.com,2008:", $feed->entry[$i]->id)[1])[0];
            /**
             * Events to add in the future:
             * - CommitCommentEvent
             * - CreateEvent
             * - DeleteEvent
             * - ForkEvent
             * - IssueCommentEvent
             * - PullRequestEvent
             * - PullRequestReviewEvent
             * - PullRequestReviewCommentEvent
             * - ReleaseEvent
             */
            switch ($eventtype) {
                case "PushEvent":
                    $entry = self::processPush($feed->entry[$i]);
                    break;
                case "IssuesEvent":
                    $entry = self::processIssue($feed->entry[$i]);
                    break;
                case "WatchEvent":
                    $entry = self::processWatch($feed->entry[$i]);
                    break;
            }
            $githubThree[$i] = $entry;
        }
        return array(
            'githubThree' => $githubThree
        );
    }
}
