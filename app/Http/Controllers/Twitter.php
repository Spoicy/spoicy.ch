<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Twitter extends Controller
{
    /**
     * Fetches the most recent tweets from @OnlyFireball_ via the Twitter API.
     * 
     * @return stdClass $tweets
     */
    public static function getTweets() {
        $response = Http::withToken(env("TWITTER_BEARER_TOKEN"))->get('https://api.twitter.com/2/users/1191275816/tweets?media.fields=preview_image_url,url&expansions=attachments.media_keys&tweet.fields=referenced_tweets,created_at&exclude=retweets,replies');
        $tweets = json_decode($response);
        return $tweets;
    }

    /**
     * Returns the variables required for the Twitter template.
     * 
     * @todo Include links from tweets that aren't media
     * 
     * @return array $variables
     */
    public static function variables() {
        $data = self::getTweets();
        $tweets = $data->data;
        $includes = $data->includes->media;
        $twitterPosts = array();
        for ($i = 0; $i < 5; $i++) {
            $tweet = new \stdClass();
            $tweet->text = $tweets[$i]->text;
            $datetime = new DateTime($tweets[$i]->created_at);
            $tweet->datetime = $datetime->format("g:i A · M j, Y");
            $tweet->link = "https://www.twitter.com/OnlyFireball_/status/" . $tweets[0]->id;
            if (isset($tweets[$i]->attachments)) {
                $mediakey = $tweets[$i]->attachments->media_keys[0];
                foreach ($includes as $media) {
                    if ($media->media_key == $mediakey) {
                        if ($media->type == "photo") {
                            $tweet->media = $media->url;
                        } else {
                            $tweet->media = $media->preview_image_url;
                        }
                    }
                }
                $tweet->text = substr($tweet->text, 0, strpos($tweet->text, "https://t.co")-1);
            } else {
                $tweet->media = null;
            }
            $twitterPosts[$i] = $tweet;
        }
        return array(
            'twitterPosts' => $twitterPosts
        );
    }
}
