<?php

namespace App\Console\Commands;

use App\Models\Tweet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;

class UpdateTwitter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the most recent tweets.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Command is disabled in preparation for Twitter's free API tier being taken away.
        return 0;
        if (!Schema::hasTable('tweets')) {
            die("No table found, please run migrations first.");
        }
        /* Put all tweet sids into array */
        $query = Tweet::all();
        $sids = array();
        foreach ($query as $result) {
            $sids[] = $result->sid;
        }

        /* Retrieve all tweets and media from API */
        $response = Http::withToken(env("TWITTER_BEARER_TOKEN"))->get('https://api.twitter.com/2/users/1191275816/tweets?max_results=30&media.fields=preview_image_url,url&expansions=attachments.media_keys&tweet.fields=referenced_tweets,created_at&exclude=retweets,replies');
        $tweets = json_decode($response);
        $includes = $tweets->includes->media;
        $tweets = array_reverse($tweets->data);

        foreach ($tweets as $tweet) {
            /* Check if tweet is already in database */
            if (!in_array($tweet->id, $sids)) {
                $datetime = new \DateTime($tweet->created_at);
                $newTweet = Tweet::create([
                    'sid' => $tweet->id,
                    'text' => $tweet->text,
                    'link' => 'https://www.twitter.com/OnlyFireball_/status/' . $tweet->id,
                    'date' => $datetime->getTimestamp(),
                    'media' => ''
                ]);
                /* Check if there's available media to display */
                if (isset($tweet->attachments)) {
                    $mediakey = $tweet->attachments->media_keys[0];
                    foreach ($includes as $media) {
                        if ($media->media_key == $mediakey) {
                            if ($media->type == "photo") {
                                $newTweet->media = $media->url;
                            } else {
                                $newTweet->media = $media->preview_image_url;
                            }
                        }
                    }
                }
                $newTweet->save();
            }
        }
        return Command::SUCCESS;
    }
}
