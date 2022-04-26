<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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
        $entry->datetime = $date->getTimestamp();
        //$entry->datetime = $date->format("M j, Y");
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
        $entry->entrydata = array();
        $entry->type = "Push";
        $entry->entrydata["repo"] = explode("/compare", explode("https://github.com/", $entry->link)[1])[0];
        $entry->entrydata["branch"] = explode(" in", explode("pushed to ", $entry->title)[1])[0];
        $entry->entrydata["commits"] = array();
        $commits = self::callGitHubAPI($entry->link);
        foreach ($commits->commits as $commit) {
            $commitEntry = new \stdClass();
            $commitEntry->id = substr($commit->sha, 0, 7);
            $commitEntry->link = $commit->html_url;
            $commitEntry->message = $commit->commit->message;
            $entry->entrydata["commits"][] = $commitEntry;
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
        $entry->entrydata = array();
        $entry->type = "Watch";
        $repo = self::callGitHubAPI($entry->link);
        $entry->entrydata["repo"] = $repo->full_name;
        $entry->entrydata["repodesc"] = $repo->description;
        $entry->entrydata["lang"] = $repo->language;
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
        $entry->entrydata = array();
        $entry->type = "Issue";
        $entry->entrydata["repo"] = explode("/issues", explode("https://github.com/", $entry->link)[1])[0];
        $entry->entrydata["issuetype"] = explode(" an", explode($entry->author . " ", $entry->title)[1])[0];
        $issue = self::callGitHubAPI($entry->link);
        $entry->entrydata["issuename"] = $issue->title;
        $entry->entrydata["issuenum"] = $issue->number;
        return $entry;
    }

    /**
     * Returns the variables required for the GitHub template.
     * 
     * @return array $variables
     */
    public static function variables() {
        $githubQuery = DB::table('github')->orderby('date', 'desc')->get();
        $githubEntries = array();
        foreach ($githubQuery as $entry) {
            $datetime = new \DateTime();
            $datetime->setTimestamp($entry->date);
            $entry->date = $datetime->format("M j, Y");
            $entry->entrydata = json_decode($entry->entrydata);
            $githubEntries[] = $entry;
        }

        return array(
            'githubEntries' => array_slice($githubEntries, 0, 4)
        );
    }
}
