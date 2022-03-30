<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GitHub extends Controller
{
    /**
     * Fetches the GitHub feed for the user Spoicy.
     * 
     * @return SimpleXMLElement $feed
     */
    public static function getFeed() {
        $feed = simplexml_load_file("https://github.com/spoicy.atom");
        return $feed;
    }

    /**
     * Creates a base entry class for the process functions.
     * 
     * @param  SimpleXMLElement $data
     * @return stdClass         $entry
     */
    public static function createEntry($data) {
        $entry = new \stdClass();
        $entry->title = (string) $data->title;
        $entry->link = (string) $data->link->attributes()->href;
        $entry->author = (string) $data->author->name;
        $date = new \DateTime((string) $data->published);
        $entry->datetime = $date->format("M j, Y");
        return $entry;
    }

    /**
     * Processes GitHub API requests.
     * 
     * @param  string   $link
     * @return stdClass $response
     */
    public static function callGitHubAPI($link) {
        $response = Http::withHeaders([
            'User-Agent' => 'request'
        ])->get("https://api.github.com/repos".explode("https://github.com", $link)[1]);
        $response = json_decode($response);
        return $response;
    }

    /**
     * Processes the data for PushEvents
     * 
     * @param  SimpleXMLElement $data
     * @return stdClass         $entry
     */
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

    /**
     * Processes the data for WatchEvents
     * 
     * @param  SimpleXMLElement $data
     * @return stdClass         $entry
     */
    public static function processWatch($data) {
        $entry = self::createEntry($data);
        $entry->type = "Watch";
        $repo = self::callGitHubAPI($entry->link);
        $entry->repo = $repo->full_name;
        $entry->repodesc = $repo->description;
        $entry->lang = $repo->language;
        return $entry;
    }

    /**
     * Processes the data for IssueEvents
     * 
     * @param  SimpleXMLElement $data
     * @return stdClass         $entry
     */
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
        $githubEntries = array();
        $j = 0;
        for ($i = 0; $i < count($feed->entry); $i++) {
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
                default:
                    continue 2;
            }
            $j++;
            $githubEntries[$i] = $entry;
            if ($j == 4) {
                break;
            }
        }
        return array(
            'githubEntries' => $githubEntries
        );
    }
}
