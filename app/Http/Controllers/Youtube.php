<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Youtube extends Controller
{
    //

    public static function getVideos() {
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
    public static function getDateFormat($date) {
        $date = substr(str_replace('T', ' ', $date), 0, -1);
        $runDate = new \DateTime($date);
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
    public static function variables() {
        $videos = self::getVideos();
        $youtubeFive = array();
        foreach ($videos as $key => $video) {
            $temp = new \stdClass();
            $temp->id = $video->snippet->resourceId->videoId;
            $temp->thumbnail = $video->snippet->thumbnails->high->url;
            $temp->title = $video->snippet->title;
            $temp->date = self::getDateFormat($video->snippet->publishedAt);
            $youtubeFive[] = $temp;
        }
        return array(
            'youtubeFive' => $youtubeFive
        );
    }
}
