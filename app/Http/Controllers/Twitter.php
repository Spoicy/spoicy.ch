<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Twitter extends Controller
{
    //

    public static function getTweets() {
        $response = Http::withToken(env("TWITTER_BEARER_TOKEN"))->get('https://api.twitter.com/2/users/1191275816/tweets?media.fields=preview_image_url,url&expansions=attachments.media_keys&tweet.fields=referenced_tweets&exclude=retweets,replies');
        $tweets = json_decode($response);
        return $tweets;
    }

    /**
     * Returns the variables required for the Youtube template.
     * 
     * @return array $variables
     */
    public static function variables() {
        $data = self::getTweets();
        $tweets = $data->data;
        $includes = $data->includes->media;
        $twitterFive = array();
        for ($i = 0; $i < 5; $i++) {
            $tweet = new \stdClass();
            $tweet->text = $tweets[$i]->text;
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
            $twitterFive[$i] = $tweet;
        }
        return array(
            'twitterFive' => $twitterFive
        );
    }
}
