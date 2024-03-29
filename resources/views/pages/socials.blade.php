<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fireball</title>
        <meta name="description" content="Spoicy's Linktree for various socials.">

        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body class="pink">
        @include('components/other/overlay', ['nav' => 'hLinktree'])
        <div class="container text-center linktree-container site-container">
            <div class="main-div flex-column">
                <img src="img/fireball.png" alt="fireball.png" />
                <h1>Fireball</h1>
            </div>
            <div class="social-list flex-column">
                <a href="https://www.twitch.tv/onlyfireball" target="_blank" type="button" class="btn btn-blue first-link">Twitch</a>
                <a href="https://www.youtube.com/channel/UCsVw7FLt28Boqi7e6CnkoXg" target="_blank" type="button" class="btn btn-pink">YouTube</a>
                <a href="https://www.twitter.com/onlyfireball_" target="_blank" type="button" class="btn btn-white">Twitter</a>
                <a href="https://www.speedrun.com/user/fireball" target="_blank" type="button" class="btn btn-pink">Speedrun</a>
                <input type="button" class="btn btn-blue last-link" value="Discord" onclick="window.alert('Discord: onlyfireball');"/>
            </div>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
