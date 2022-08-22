<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpeedrunResource;
use App\Models\Speedrun;

class SpeedrunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return array(
            'data' => SpeedrunResource::collection(Speedrun::orderby('date', 'desc')->get())
        );
    }
}
