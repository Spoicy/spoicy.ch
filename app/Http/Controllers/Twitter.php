<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Twitter extends Controller
{
    //

    public static function getTweets() {
        $response = Http::withToken(env("TWITTER_BEARER_TOKEN"))->get('https://api.twitter.com/2/users/1191275816/tweets?tweet.fields=referenced_tweets&exclude=retweets,replies');
        $tweets = json_decode($response);
        return $tweets->data;
    }

    /**
     * Returns the variables required for the Youtube template.
     * 
     * @return array $variables
     */
    public static function variables() {
        $videos = self::getTweets();
        $twitterFive = array();
        return array(
            'twitterFive' => $twitterFive
        );
    }
}
