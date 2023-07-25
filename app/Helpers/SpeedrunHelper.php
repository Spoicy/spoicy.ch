<?php

namespace App\Helpers;

class SpeedrunHelper
{
    /**
     * Formats the speedrun date to be in a similar format to SRDC.
     * 
     * @param  string $date
     * @return string $speedrunDate
     */
    public static function getDateFormat(string $date): string {
        $runDate = new \DateTime($date . " 12:00:00");
        $now = new \DateTime();
        $diff = date_diff($runDate, $now);
        $thresholds = ['year' => $diff->y, 'month' => $diff->m, 'day' => $diff->d];

        // years -> months -> days ->
        foreach ($thresholds as $timeperiod => $amount) {
            if ($amount) {
                $speedrunDate = $amount;
                if ($amount > 1) {
                    $timeperiod .= "s";
                }
                $speedrunDate .= " $timeperiod ago";
                break;
            }
        }
        if (!isset($speedrunDate)) {
            $speedrunDate = "Today";
        }
        return $speedrunDate;
    }

    /**
     * Formats the speedrun time from seconds to h:i:s.ms
     * 
     * @param  float  $time
     * @return string $speedrunTime
     */
    public static function getTimeFormat(float $time): string {
        if ($time < 3600) {
            $timePattern = "i:s";
        } else {
            $timePattern = "H:i:s";
        }
        $speedrunTime = date($timePattern, $time);
        /* This code is messy and not self explanatory, but it works as intended no matter how many decimals are required, so will not be reworked. */
        if ($ms = fmod($time, 1)) {
            $errorComp = 0;
            $floatError = strpos($ms, "9999");
            if ($floatError) {
                $errorComp = 1;
            } else {
                $floatError = strpos($ms, "0000");
            }
            if ($floatError) {
                $ms = str_replace(substr($ms, $floatError), "", $ms);
                $ms = strval(floatval($ms) + ($errorComp * pow(0.1, $floatError - 2)));
            }
            $ms = substr($ms, strpos($ms, ".") + 1);
            $ms = str_pad($ms, 3, "0");
            $speedrunTime .= "." . $ms;
        }
        if ($time >= 86400) {
            $days = round(($time - ($time % 86400)) / 86400);
            $speedrunTime = $days . "d " . $speedrunTime;
        }
        return $speedrunTime;
    }

    /**
     * Rounds a time in integer format to end with 00, 17, 33, 50, 67 or 83.
     * 
     * @param  int $time
     * @return int $roundedTime
     */
    public static function roundTo60Frames(int $time): int {
        $lastTwoDigits = intval(substr($time, -2));
        $thresholds = [17, 33, 50, 67, 83];
        $rounded = false;
        foreach ($thresholds as $threshold) {
            if ($lastTwoDigits <= $threshold) {
                $lastTwoDigits = $threshold;
                $rounded = true;
                break;
            }
        }
        if (!$rounded) {
            $threshold = '00';
            $time += 100;
        }
        return intval(substr($time, 0, -2) . $threshold);
    }
}