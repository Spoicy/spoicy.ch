<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Youtube extends Controller
{
    //

    public function getVideos() {
        $playlistItems = json_decode(file("https://youtube.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=UUsVw7FLt28Boqi7e6CnkoXg&key=" . $_ENV["YOUTUBE_API_KEY"]));
        $videos = $playlistItems[0]["items"];
    }
}
