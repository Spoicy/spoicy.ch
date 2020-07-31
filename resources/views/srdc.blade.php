<?php

use App\Http\Controllers\SRDC;
use Illuminate\Support\Facades\DB;

$speedrunsQuery = DB::table('speedruns')->get();
$speedruns = array();
foreach($speedrunsQuery as $speedrun) {
    $speedruns[] = $speedrun;
}
$speedrunsFive = array_slice($speedruns, 0, 5);
?>
<h1>Speedruns</h1>
<?php
foreach ($speedrunsFive as $key => $speedrun) { ?>
    <div class="row speedrun">
        <div class="col-lg-4 col-md-3 col-sm-4 col-5 speedrun-logo">
            <img src="<?php echo $speedrun->image; ?>" alt="<?php echo $speedrun->game; ?>" />
        </div>
        <div class="col-lg-8 col-md-9 col-sm-8 col-7 speedrun-text">
            <a href="<?php echo $speedrun->game_link; ?>"><?php echo $speedrun->game; ?></a>
            <br>
            <a href="<?php echo $speedrun->category_link; ?>" class="speedrun-category"><?php echo $speedrun->category; ?></a>
            <span class="speedrun-time"><?php echo SRDC::getTimeFormat($speedrun->time); ?></span>
            <span class="speedrun-date"><?php echo SRDC::getDateFormat($speedrun->date); ?></span>
        </div>
    </div>
<?php
}
?>