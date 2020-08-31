@php

//use Illuminate\Support\Facades\DB;

@endphp

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Maddening Euphoria</title>
        <meta name="description" content="Spoicy">

        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div class="container meu-container">
            <form action="meuphoria" method="post">
                @csrf
                <button id="calcGolds" type="submit">Lol!</button>
                <input type="file" name="splitFile" id="splitFile" />
                <div id="demo"> 
                    @if ($splitFile)
                        {{ $splitFile }}
                    @endif
                </div>
            </form>
        </div>
    </body>
</html>