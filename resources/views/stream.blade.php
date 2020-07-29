<?php
use Illuminate\Support\Facades\DB;
?>


<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Social Media</title>
        <meta name="description" content="Spoicy">

        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
    <?php 
    $speedrunsQuery = DB::table('speedruns')->get();
    $speedruns = array();
    foreach($speedrunsQuery as $speedrun) {
        $speedruns[] = $speedrun;
    }
    $speedrunsFive = array_slice($speedruns, 0, 5); 

    ?>
        <div class="container stream-container">
            <div class="row">
                <div class="col-md-6 col-xs-12"></div>
                <div class="col-md-6 col-xs-12"></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-xs-12"></div>
                <div class="col-md-6 col-xs-12">
                    <h1>Speedruns</h1>
                    <?php 
                        foreach ($speedrunsFive as $key => $speedrun) {
                            if ($speedrun->time < 3600) {
                                $timePattern = "i:s";
                            } else {
                                $timePattern = "H:i:s";
                            }
                            $speedrunTime = date($timePattern, $speedrun->time);
                            if ($ms = fmod($speedrun->time, 1)) {
                                $ms = substr($ms, strpos($ms, ".") + 1);
                                $ms = str_pad($ms, 3, "0");
                                $speedrunTime .= "." . $ms;
                            }
                            $date = strtotime($speedrun->date);
                            $since = time() - $date;
                            // years -> months -> days ->
                            if ($since >= 60*60*24*365) {
                                $speedrunDate = floor($since / (60*60*24*365));
                                $timeperiod = " year";
                                if ($speedrunDate > 1) {
                                    $timeperiod .= "s";
                                }
                                $speedrunDate .= $timeperiod . " ago";
                            } elseif ($since >= 60*60*24*30) {
                                $speedrunDate = floor($since / (60*60*24*30));
                                $timeperiod = " month";
                                if ($speedrunDate > 1) {
                                    $timeperiod .= "s";
                                }
                                $speedrunDate .= $timeperiod . " ago";
                            } elseif ($since >= 60*60*24) {
                                $speedrunDate = floor($since / (60*60*24));
                                $timeperiod = " day";
                                if ($speedrunDate > 1) {
                                    $timeperiod .= "s";
                                }
                                $speedrunDate .= $timeperiod . " ago";
                            } else {
                                $speedrunDate = "Today";
                            }

                            ?>
                            <img src="<?php echo $speedrun->image; ?>" alt="<?php echo $speedrun->game; ?>" />
                            <a href="<?php echo $speedrun->game_link; ?>"><?php echo $speedrun->game; ?></a>
                            <a href="<?php echo $speedrun->category_link; ?>" class="speedrun-category"><?php echo $speedrun->category; ?></a>
                            <span class="speedrun-time"><?php echo $speedrunTime; ?></span>
                            <span class="speedrun-date"><?php echo $speedrunDate; ?></span>
                            <br>
                            <?php 
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>