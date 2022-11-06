@php
use Illuminate\Support\Facades\View;
$i = 0;
@endphp

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Social Media</title>
        <meta name="description" content="Spoicy's various social medias.">

        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="https://twemoji.maxcdn.com/v/latest/twemoji.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="soft-blue">
        @include('components.other.overlay', ['nav' => 'hSocial', 'title' => 'Social Media'])
        <div class="container stream-container site-container">
            <div class="stream-rows">
                @foreach ($available_templates as $template => $data)
                    @if (View::exists('components.media.'.$template) && count($data))
                        @if ($i % 2 == 0)
                            <div class="row stream-row">
                                <div class="col-lg-6 col-xs-12 {{$template}}-container streamchild-container">
                                    @include('components.media.'.$template, ['data' => $data])
                                </div>
                        @else
                                <div class="col-lg-6 col-xs-12 {{$template}}-container streamchild-container">
                                    @include('components.media.'.$template, ['data' => $data])
                                </div>
                            </div>
                        @endif
                        @php
                            $i++;
                        @endphp
                    @endif
                @endforeach
    
                @if ($i % 2 == 1)
                            </div>
                @endif
            </div>
        </div>
        <script src="js/app.js"></script>
        <script>twemoji.parse(document.body);</script>
    </body>
</html>