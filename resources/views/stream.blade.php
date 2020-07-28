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
    $speedruns = json_decode(file("https://www.speedrun.com/api/v1/runs?user=kj9407x4&orderby=submitted&direction=desc")[0])->data;
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
                            $speedrunLinks = array();
                            foreach($speedrun->links as $link) {
                                $speedrunLinks[$link->rel] = $link->uri;
                            }
                            $game = json_decode(file($speedrunLinks["game"])[0])->data;
                            $category = json_decode(file($speedrunLinks["category"])[0])->data;
                            $categoryLinks = array();
                            foreach ($category->links as $link) {
                                $categoryLinks[$link->rel] = $link->uri;
                            }
                            if (in_array("variables", array_keys($categoryLinks))) {
                                $variables = json_decode(file($categoryLinks["variables"])[0])->data;
                                if (count($variables)) {
                                    $variables = $variables[0];
                                } else {
                                    unset($variables);
                                }
                            }
                            $variableLabel = null;
                            if (isset($variables) && $variables->{'is-subcategory'}) {
                                $key = $variables->id;
                                if (isset($speedrun->values->$key)) {
                                    $variable = $speedrun->values->$key;
                                    $variableLabel = $variables->values->values->{"$variable"}->label;
                                }
                            }
                            $level = null;
                            if (in_array("level", array_keys($speedrunLinks))) {
                                $level = json_decode(file($speedrunLinks["level"])[0])->data;
                            }
                            $logo = $game->assets->{'cover-medium'}->uri;
                            $time = $speedrun->times->primary_t;

                            if ($time < 3600) {
                                $timePattern = "i:s";
                            } else {
                                $timePattern = "H:i:s";
                            }
                            $speedrunTime = date($timePattern, $time);
                            if (is_float($time)) {
                                $ms = strval(fmod($time, 1));
                                $ms = substr($ms, strpos($ms, ".") + 1);
                                $ms = str_pad($ms, 3, "0");
                                $speedrunTime .= "." . $ms;
                            }
                            ?>
                            <img src="<?php echo $logo; ?>" alt="<?php echo $game->names->international; ?>" />
                            <a href="<?php echo $game->weblink; ?>"><?php echo $game->names->international; ?></a>
                            <a href="<?php echo $category->weblink; ?>" class="speedrun-category">
                                <?php
                                if ($level) {
                                    echo $level->name . ": ";
                                }
                                echo $category->name;
                                if ($variableLabel) {
                                    echo " - " . $variableLabel;
                                }
                                ?>
                            </a>
                            <span class="speedrun-time"><?php echo $speedrunTime; ?></span>
                            <br>
                            <?php 
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>