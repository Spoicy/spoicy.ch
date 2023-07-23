<?php

namespace App\Console\Commands;

use App\Models\YoutubeVideo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateYoutube extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the most recent YouTube videos.';

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
        if (!Schema::hasTable('youtube_videos')) {
            die("No table found, please run migrations first.");
        }

        $youtubeVideos = YoutubeVideo::all();
        $sids = array();
        foreach ($youtubeVideos as $item) {
            $sids[] = $item->sid;
        } 

        $playlistItems = json_decode(implode('', file("https://youtube.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=UUsVw7FLt28Boqi7e6CnkoXg&maxResults=30&key=" .
            env("YOUTUBE_API_KEY"))));
        $playlistItems = array_reverse($playlistItems->items);

        foreach ($playlistItems as $video) {
            if (!in_array($video->snippet->resourceId->videoId, $sids)) {
                $datetime = new \DateTime(substr(str_replace('T', ' ', $video->snippet->publishedAt), 0, -1));
                $newVideo = YoutubeVideo::create([
                    'sid' => $video->snippet->resourceId->videoId,
                    'title' => $video->snippet->title,
                    'thumbnail' => $video->snippet->thumbnails->high->url,
                    'date' => $datetime->getTimestamp(),
                    'views' => 0
                ]);
            }
        }
        return 0;
    }
}
