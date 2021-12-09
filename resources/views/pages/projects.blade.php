<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Spoicy</title>
        <meta name="description" content="Spoicy">

        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body class="light-blue">
        <div class="container text-center projects-container">
            <div class="main-div">
                <div class="row">
                    <img src="img/fireball.png" alt="fireball.png" />
                </div>
                <div class="row">
                    <h1>Spoicy</h1>
                </div>
            </div>
            <div class="row project-1">
                <h2>Projects:</h2>
            </div>
            <div class="row project-2">
                <a href="https://github.com/Spoicy/spoicy.ch" target="_blank" type="button"
                    data-toggle="tooltip" title="My personal website using the Laravel Framework" class="btn first-link">spoicy.ch</a>
            </div>
            <div class="row project-3">
                <a href="https://github.com/Spoicy/satool" target="_blank" type="button"
                    data-toggle="tooltip" title="A Moodle Plugin for managing semester projects at Kantonsschule Frauenfeld" class="btn">SA-Tool</a>
            </div>
            <div class="row project-4">
                <a href="https://github.com/Spoicy/fitcheck" target="_blank" type="button"
                    data-toggle="tooltip" title="A Moodle Plugin for physical education classes at Kantonsschule Frauenfeld" class="btn">FitCheck</a>
            </div>
            <div class="row project-5">
                <a href="https://github.com/Spoicy/birthday" target="_blank" type="button"
                    data-toggle="tooltip" title="A Moodle Block by Anthony Borrow, updated by me to work on Moodle 3.7" class="btn">Birthday-Block</a>
            </div>
        </div>
    </body>
</html>
