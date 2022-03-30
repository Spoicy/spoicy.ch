<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Stream extends Controller
{
    /**
     * Prepares all of the necessary variables for the stream component templates.
     * 
     * @return View $page
     */
    public static function view() {
        $available_templates = array(
            'srdc' => SRDC::variables(),
            'youtube' => Youtube::variables(),
            'twitter' => Twitter::variables(),
            'github' => GitHub::variables()
        );
        return view('pages/stream', [
            'available_templates' => $available_templates,
        ]);
    }
}
