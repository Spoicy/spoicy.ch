<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SRDC extends Controller
{
    /**
     * Format the speedrun date to be in a similar format to SRDC
     * 
     * @param  string $date
     * @return string $speedrunDate
     */
    public static function getDateFormat($date) {
        $runDate = new \DateTime($date . " 12:00:00");
        $now = new \DateTime();
        $diff = date_diff($runDate, $now);
        $years = $diff->format('%y');
        $months = $diff->format('%m');
        $days = $diff->format('%d');

        // years -> months -> days ->
        if ($years) {
            $speedrunDate = $years;
            $timeperiod = " year";
            if ($speedrunDate > 1) {
                $timeperiod .= "s";
            }
            $speedrunDate .= $timeperiod . " ago";
        } elseif ($months) {
            $speedrunDate = $months;
            $timeperiod = " month";
            if ($speedrunDate > 1) {
                $timeperiod .= "s";
            }
            $speedrunDate .= $timeperiod . " ago";
        } elseif ($days) {
            $speedrunDate = $days;
            $timeperiod = " day";
            if ($speedrunDate > 1) {
                $timeperiod .= "s";
            }
            $speedrunDate .= $timeperiod . " ago";
        } else {
            $speedrunDate = "Today";
        }
        return $speedrunDate;
    }

    /**
     * Format the speedrun time from seconds to h:i:s.ms
     * 
     * @param  float  $time
     * @return string $speedrunTime
     */
    public static function getTimeFormat($time) {
        if ($time < 3600) {
            $timePattern = "i:s";
        } else {
            $timePattern = "H:i:s";
        }
        $speedrunTime = date($timePattern, $time);
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
        return $speedrunTime;
    }

    /**
     * Returns the variables required for the SRDC template.
     * 
     * @return array $variables
     */
    public static function variables() {
        $speedrunsQuery = DB::table('speedruns')->orderby('date', 'desc')->get();
        $speedruns = array();
        foreach($speedrunsQuery as $speedrun) {
            $speedruns[] = $speedrun;
        }
        return array(
            'srdcRuns' => array_slice($speedruns, 0, 5)
        );
    }
}
