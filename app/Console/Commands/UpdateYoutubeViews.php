<?php

namespace App\Console\Commands;

use App\Models\YoutubeVideo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateYoutubeViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:updateviews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all videos with their current view count.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sids = YoutubeVideo::pluck('sid')->toArray();
        $chunks = array_chunk($sids, 50);

        foreach ($chunks as $chunk) {
            $idList = implode(",", $chunk);

            // ?part=snippet&playlistId=UUsVw7FLt28Boqi7e6CnkoXg&maxResults=30&key=" . env("YOUTUBE_API_KEY")
            $response = Http::get("https://youtube.googleapis.com/youtube/v3/videos", [
                'part' => 'statistics',
                'id' => $idList,
                'key' => env("YOUTUBE_API_KEY")
            ]);

            $videos = $response->object()->items;
            foreach ($videos as $video) {
                YoutubeVideo::where('sid', $video->id)
                    ->update([
                        'views' => $video->statistics->viewCount
                    ]);
            }
        }

        return Command::SUCCESS;
    }
}
