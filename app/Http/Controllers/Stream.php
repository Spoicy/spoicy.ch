<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Stream extends Controller
{
    //

    public static function view() {
        $available_templates = array(
            'twitter' => '',
            'youtube' => '',
            'twitch' => '',
            'srdc' => SRDC::variables()
        );
        return view('pages/stream', [
            'available_templates' => $available_templates,
        ]);
    }
}
