<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div class="container text-center main-container">
            <div class="row">
                <img src="img/fireball.png" alt="fireball.png" />
            </div>
            <div class="row">
                <h1>Fireball</h1>
            </div>
            <div class="row">
                <a href="https://www.twitch.tv/onlyfireball" target="_blank" type="button" class="btn btn-blue first-link">Twitch</a>
            </div>
            <div class="row">
                <a href="https://www.youtube.com/channel/UCsVw7FLt28Boqi7e6CnkoXg" target="_blank" type="button" class="btn btn-pink">YouTube</a>
            </div>
            <div class="row">
                <a href="https://www.twitter.com/onlyfireball_" target="_blank" type="button" class="btn btn-white">Twitter</a>
            </div>
            <div class="row">
                <a href="https://www.speedrun.com/user/fireball" target="_blank" type="button" class="btn btn-pink">Speedrun</a>
            </div>
            <div class="row">
                <input type="button" class="btn btn-blue last-link" value="Discord" onclick="window.alert('Discord: Fireball#4308');"/>
            </div>
        </div>
    </body>
</html>
