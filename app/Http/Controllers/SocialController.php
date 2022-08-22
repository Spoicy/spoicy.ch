<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class SocialController extends Controller
{
    /**
     * Prepares all of the necessary data for the stream component templates.
     * 
     * @return View $page
     */
    public static function view(): \Illuminate\Contracts\View\View {
        $available_templates = array(
            'srdc' => array_slice(json_decode(Http::get(env('APP_URL') . '/api/speedruns'))->data, 0, 5),
            'youtube' => array_slice(json_decode(Http::get(env('APP_URL') . '/api/youtubevideos'))->data, 0, 5),
            'twitter' => array_slice(json_decode(Http::get(env('APP_URL') . '/api/tweets'))->data, 0, 5),
            'github' => array_slice(json_decode(Http::get(env('APP_URL') . '/api/githubevents'))->data, 0, 4)
        );
        return view('pages/social', [
            'available_templates' => $available_templates,
        ]);
    }
}
