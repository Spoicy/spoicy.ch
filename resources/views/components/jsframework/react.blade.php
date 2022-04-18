@php
use Illuminate\Support\Facades\View;
$i = 0;
@endphp

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <title>React</title>
        <meta name="description" content="Spoicy's collection of React projects.">
    
        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div id="react-calculator">
            <div id="calc-display">
                <input type="text" readonly>
            </div>
            <div id="calc-buttons">
                <div id="calc-row"></div>
                <div id="calc-row"></div>
                <div id="calc-row"></div>
                <div id="calc-row"></div>
                <div id="calc-row"></div>
            </div>
        </div>

        <!-- Load React -->
        <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
        <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>

        <!-- Load custom React components -->
    </body>
</html>