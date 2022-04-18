@php
use Illuminate\Support\Facades\View;
$i = 0;
$alpharange = range('A', 'Z')
@endphp

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <title>Double Alphabet</title>
        <meta name="description" content="Purpcord mod team's collection of double alphabet phrases.">
        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="container alphabet-container site-container">
            <h1>Double Alphabet</h1>
            <h4>First Letter</h4>
            @foreach ($alpharange as $alpha)
                @if ($alpha == "A")
                    <input type="radio" class="btn-check" name="first" value="{{$alpha}}" id="first{{$alpha}}" autocomplete="off" checked>
                @else
                    <input type="radio" class="btn-check" name="first" value="{{$alpha}}" id="first{{$alpha}}" autocomplete="off">
                @endif
                <label class="btn btn-secondary" for="first{{$alpha}}">{{$alpha}}</label>
            @endforeach
            <h4>Second Letter</h4>
            @foreach ($alpharange as $alpha)
                @if ($alpha == "A")
                    <input type="radio" class="btn-check" name="second" value="{{$alpha}}" id="second{{$alpha}}" autocomplete="off" checked>
                @else
                    <input type="radio" class="btn-check" name="second" value="{{$alpha}}" id="second{{$alpha}}" autocomplete="off">
                @endif
                <label class="btn btn-secondary" for="second{{$alpha}}">{{$alpha}}</label>
            @endforeach
            <h4 class="currsel">AA</h4>
        </div>
        <script type="text/javascript">
            $('input[type=radio]').change(function() {
                var string = $('input[name=first]:checked').val() + $('input[name=second]:checked').val();
                $('.currsel').text(string);
                console.log(string);
            });
        </script>
    </body>
</html>