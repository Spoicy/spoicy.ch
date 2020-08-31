<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Meuphoria extends Controller
{
    /**
     * Returns deltas for each individual split in a livesplit file
     * 
     * @param  mixed $xml
     * @return array $deltas
     */
    public static function calcBestSegments($xml) {
        //$splitFile = simplexml_load_string($xml);
        $splitFile = $xml;
        return $splitFile;
    }

    /**
     * Returns deltas for each individual split in a livesplit file
     * 
     * @param  Request        $request
     * @return View|Factory   $view
     */
    public static function view(Request $request) {
        $requestFile = $request->post('splitFile');
        if ($requestFile) {
            $splitFile = static::calcBestSegments($requestFile);
        }
        $variables = array(
            'splitFile' => (isset($splitFile)) ? $splitFile : ''
        );
        return view('meu', $variables);
    }
}
