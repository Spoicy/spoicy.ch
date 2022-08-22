<?php

namespace App\Helpers;

use App\Models\GithubEvent;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class GithubEventHelper
{
    /**
     * Fetches the GitHub feed for the user Spoicy.
     * 
     * @return SimpleXMLElement $feed
     */
    public static function getFeed(): SimpleXMLElement {
        $feed = simplexml_load_file("https://github.com/spoicy.atom");
        return $feed;
    }

    /**
     * Formats the event date to be in a similar format to GitHub.
     * 
     * @param  string $date
     * @return string $eventDate
     */
    public static function getDateFormat(string $date): string {
        $datetime = new \DateTime();
        $datetime->setTimestamp($date);
        $eventDate = $datetime->format("M j, Y");
        return $eventDate;
    }
    
    /**
     * Creates a base entry class for the process functions.
     * 
     * @param  SimpleXMLElement $data
     * @return GithubEvent         $entry
     */
    public static function createEntry(SimpleXMLElement $data): GithubEvent {
        $entry = new GithubEvent();
        $entry->sid = explode("/", $data->id)[1];
        $entry->title = (string) $data->title;
        $entry->link = (string) $data->link->attributes()->href;
        $entry->author = (string) $data->author->name;
        $date = new \DateTime((string) $data->published);
        $entry->date = $date->getTimestamp();
        //$entry->datetime = $date->format("M j, Y");
        return $entry;
    }

    /**
     * Processes GitHub API requests.
     * 
     * @param  string   $link
     * @return stdClass $response
     */
    public static function callGitHubAPI(string $link): \stdClass {
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
     */
    public static function processPushEvent(SimpleXMLElement $data) {
        $entry = self::createEntry($data);
        $entrydata = array();
        $entry->type = "Push";
        $entrydata["repo"] = explode("/compare", explode("https://github.com/", $entry->link)[1])[0];
        $entrydata["branch"] = explode(" in", explode("pushed to ", $entry->title)[1])[0];
        $entrydata["commits"] = array();
        $commits = self::callGitHubAPI($entry->link);
        foreach ($commits->commits as $commit) {
            $commitEntry = new \stdClass();
            $commitEntry->id = substr($commit->sha, 0, 7);
            $commitEntry->link = $commit->html_url;
            $commitEntry->message = $commit->commit->message;
            $entrydata["commits"][] = $commitEntry;
        }
        $entry->entrydata = json_encode($entrydata);
        $entry->save();
    }

    /**
     * Processes the data for WatchEvents
     * 
     * @param  SimpleXMLElement $data
     */
    public static function processWatchEvent(SimpleXMLElement $data) {
        $entry = self::createEntry($data);
        $entrydata = array();
        $entry->type = "Watch";
        $repo = self::callGitHubAPI($entry->link);
        $entrydata["repo"] = $repo->full_name;
        $entrydata["repodesc"] = $repo->description;
        $entrydata["lang"] = $repo->language;
        $entry->entrydata = json_encode($entrydata);
        $entry->save();
    }

    /**
     * Processes the data for IssueEvents
     * 
     * @param  SimpleXMLElement $data
     */
    public static function processIssuesEvent(SimpleXMLElement $data) {
        $entry = self::createEntry($data);
        $entrydata = array();
        $entry->type = "Issue";
        $entrydata["repo"] = explode("/issues", explode("https://github.com/", $entry->link)[1])[0];
        $entrydata["issuetype"] = explode(" an", explode($entry->author . " ", $entry->title)[1])[0];
        $issue = self::callGitHubAPI($entry->link);
        $entrydata["issuename"] = $issue->title;
        $entrydata["issuenum"] = $issue->number;
        $entry->entrydata = json_encode($entrydata);
        $entry->save();
    }
}