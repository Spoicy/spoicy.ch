<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Stream extends Controller
{
    //

    public static function view() {
        $available_templates = array(
            'srdc' => SRDC::variables(),
            'youtube' => Youtube::variables(),
            'twitter' => '',
            'twitch' => ''
        );
        return view('pages/stream', [
            'available_templates' => $available_templates,
        ]);
    }
}
