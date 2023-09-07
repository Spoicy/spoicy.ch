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
        $videos = YoutubeVideo::all();
        $idList = '';
        foreach ($videos as $video) {
            $idList .= $video->sid . ',';
        }
        $idList = substr($idList, 0, -1);
        // ?part=snippet&playlistId=UUsVw7FLt28Boqi7e6CnkoXg&maxResults=30&key=" . env("YOUTUBE_API_KEY")
        $request = Http::get("https://youtube.googleapis.com/youtube/v3/videos", [
            'part' => 'statistics',
            'id' => $idList,
            'key' => env("YOUTUBE_API_KEY")
        ]);
        $requestVideos = $request->object()->items;
        foreach ($requestVideos as $video) {
            YoutubeVideo::where('sid', $video->id)
                ->update([
                    'views' => $video->statistics->viewCount
                ]);
        }
        return Command::SUCCESS;
    }
}
