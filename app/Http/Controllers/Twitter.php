<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Support\Facades\DB;

class Twitter extends Controller
{
    /**
     * Formats the tweet date to be in a similar format to Twitter.
     * 
     * @param  string $date
     * @return string $tweetDate
     */
    public static function getDateFormat($date) {
        $datetime = new \DateTime();
        $datetime->setTimestamp($date);
        $tweetDate = $datetime->format("g:i A · M j, Y");
        return $tweetDate;
    }

    /**
     * Returns the variables required for the Twitter template.
     * 
     * @todo Include links from tweets that aren't media
     * 
     * @return array $variables
     */
    public static function variables() {
        $tweets = Tweet::orderby('date', 'desc')->get();
        return array(
            'twitterPosts' => $tweets->slice(0, 5)
        );
    }
}
