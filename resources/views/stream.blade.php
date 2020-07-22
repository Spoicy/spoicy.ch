<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        <div class="container stream-container">
            <div class="text-center">
                <br><br>
                <h2>Soon</h2>
                <?php 
                $speedruns = json_decode(file("https://www.speedrun.com/api/v1/runs?user=kj9407x4&orderby=submitted&direction=desc")[0])->data;
                $speedrunsFive = array_slice($speedruns, 0, 5); 
                ?>
            </div>
        </div>
    </body>
</html>
