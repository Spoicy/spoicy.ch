<?php

namespace App\Http\Controllers;

use App\Models\YoutubeVideo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class Youtube extends Controller
{
    /**
     * Fetches the most recent videos from the OnlyFireball channel via the YouTube API.
     * 
     * @return array $items
     */
    public static function getVideos(): iterable {
        $playlistItems = json_decode(implode('', file("https://youtube.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=UUsVw7FLt28Boqi7e6CnkoXg&key=" .
            env("YOUTUBE_API_KEY"))));
        return $playlistItems->items;
    }

    /**
     * Format the speedrun date to be in a similar format to Youtube
     * 
     * @param  string $date
     * @return string $speedrunDate
     */
    public static function getDateFormat(string $date): string {
        $runDate = new \DateTime();
        $runDate->setTimestamp($date);
        $now = new \DateTime();
        $diff = date_diff($runDate, $now);
        $years = $diff->format('%y');
        $months = $diff->format('%m');
        $days = $diff->format('%d');

        // years -> months -> days ->
        if ($years) {
            $videoDate = $years;
            $timeperiod = " year";
            if ($videoDate > 1) {
                $timeperiod .= "s";
            }
            $videoDate .= $timeperiod . " ago";
        } elseif ($months) {
            $videoDate = $months;
            $timeperiod = " month";
            if ($videoDate > 1) {
                $timeperiod .= "s";
            }
            $videoDate .= $timeperiod . " ago";
        } elseif ($days) {
            $videoDate = $days;
            $timeperiod = " day";
            if ($videoDate > 1) {
                $timeperiod .= "s";
            }
            $videoDate .= $timeperiod . " ago";
        } else {
            $videoDate = "Today";
        }
        return $videoDate;
    }

    /**
     * Returns the variables required for the Youtube template.
     * 
     * @return array $variables
     */
    public static function variables(): iterable {
        if (!Schema::hasTable('youtube_videos')) {
            return array();
        }
        $youtubeVideos = YoutubeVideo::orderby('date', 'desc')->get();
        return array(
            'youtubeVideos' => $youtubeVideos->slice(0, 5)
        );
    }
}
