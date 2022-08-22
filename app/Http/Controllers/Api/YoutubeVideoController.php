<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\YoutubeVideoResource;
use App\Models\YoutubeVideo;

class YoutubeVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return array(
            'data' => YoutubeVideoResource::collection(YoutubeVideo::orderby('date', 'desc')->get())
        );
    }
}
