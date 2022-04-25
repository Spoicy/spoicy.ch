<?php

namespace App\Console\Commands;

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
        if (!Schema::hasTable('tweets')) {
            Schema::create('tweets', function ($table) {
                $table->increments('id');
                $table->char('sid', 19);
                $table->string('text', 255);
                $table->string('link', 255);
                $table->string('media', 255)->default(null);
                $table->integer('date');
            });
        }
        $tableTweets = DB::table('tweets');

        $query = $tableTweets->get('sid');
        $sids = array();
        foreach ($query as $result) {
            $sids[] = $result->sid;
        }

        $response = Http::withToken(env("TWITTER_BEARER_TOKEN"))->get('https://api.twitter.com/2/users/1191275816/tweets?max_results=30&media.fields=preview_image_url,url&expansions=attachments.media_keys&tweet.fields=referenced_tweets,created_at&exclude=retweets,replies');
        $tweets = json_decode($response);
        $includes = $tweets->includes->media;
        $tweets = array_reverse($tweets->data);

        foreach ($tweets as $tweet) {
            if (!in_array($tweet->id, $sids)) {
                $datetime = new \DateTime($tweet->created_at);
                $tweetarray = [
                    'sid' => $tweet->id,
                    'text' => $tweet->text,
                    'link' => "https://www.twitter.com/OnlyFireball_/status/" . $tweet->id,
                    'date' => $datetime->getTimestamp(),
                    'media' => ''
                ];
                if (isset($tweet->attachments)) {
                    $mediakey = $tweet->attachments->media_keys[0];
                    foreach ($includes as $media) {
                        if ($media->media_key == $mediakey) {
                            if ($media->type == "photo") {
                                $tweetarray['media'] = $media->url;
                            } else {
                                $tweetarray['media'] = $media->preview_image_url;
                            }
                            $i = 0;
                        }
                    }
                }
                $tableTweets->insert($tweetarray);
            }
        }

        return 0;
    }
}
