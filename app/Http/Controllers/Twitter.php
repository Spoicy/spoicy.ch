<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\DB;

class Twitter extends Controller
{
    /**
     * Returns the variables required for the Twitter template.
     * 
     * @todo Include links from tweets that aren't media
     * 
     * @return array $variables
     */
    public static function variables() {
        $tweetsQuery = DB::table('tweets')->orderby('date', 'desc')->get();
        $tweets = array();
        foreach($tweetsQuery as $tweet) {
            $datetime = new DateTime();
            $datetime->setTimestamp($tweet->date);
            $tweet->date = $datetime->format("g:i A · M j, Y");
            $twitterPosts[] = $tweet;
        }

        return array(
            'twitterPosts' => array_slice($twitterPosts, 0, 5)
        );
    }
}
