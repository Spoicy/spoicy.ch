<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GithubEventResource;
use App\Models\GithubEvent;
use Illuminate\Http\Request;

class GithubEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return array(
            'data' => GithubEventResource::collection(GithubEvent::orderby('date', 'desc')->get())
        );
    }
}
