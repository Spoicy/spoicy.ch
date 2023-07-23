<?php

namespace App\Helpers;

class YoutubeVideoHelper
{
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

    public static function getViewFormat(int $views): string {
        if ($views == 1) {
            return "1 view";
        }
        if ($views > 1000) {
            $views = ($views - $views % 100) / 100;
            if ($views % 10 != 0) {
                return substr($views, 0, -1) . "." . substr($views, -1) . "k views";
            } else {
                return ($views / 10) . "k views";
            }
        }
        return $views . " views";
    }
}