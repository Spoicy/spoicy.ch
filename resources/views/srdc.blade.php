@php

use App\Http\Controllers\SRDC;
use Illuminate\Support\Facades\DB;

$speedrunsQuery = DB::table('speedruns')->get();
$speedruns = array();
foreach($speedrunsQuery as $speedrun) {
    $speedruns[] = $speedrun;
}
$speedrunsFive = array_slice($speedruns, 0, 5);
@endphp
<h1>Speedruns</h1>
@foreach ($speedrunsFive as $key => $speedrun)
    <div class="row speedrun">
        <div class="col-lg-4 col-md-3 col-sm-4 col-5 speedrun-logo">
            <img src="{{$speedrun->image}}" alt="{{$speedrun->game}}" />
        </div>
        <div class="col-lg-8 col-md-9 col-sm-8 col-7 speedrun-text">
            <a href="{{$speedrun->game_link}}">{{$speedrun->game}}</a>
            <br>
            <a href="{{$speedrun->category_link}}" class="speedrun-category">{{$speedrun->category}}</a>
            <span class="speedrun-time">{{SRDC::getTimeFormat($speedrun->time)}}</span>
            <span class="speedrun-date">{{SRDC::getDateFormat($speedrun->date)}}</span>
        </div>
    </div>
@endforeach