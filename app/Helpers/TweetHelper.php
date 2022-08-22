<?php

namespace App\Helpers;

class TweetHelper
{
    /**
     * Formats the tweet date to be in a similar format to Twitter.
     * 
     * @param  string $date
     * @return string $tweetDate
     */
    public static function getDateFormat(string $date): string {
        $datetime = new \DateTime();
        $datetime->setTimestamp($date);
        $tweetDate = $datetime->format("g:i A · M j, Y");
        return $tweetDate;
    }
}