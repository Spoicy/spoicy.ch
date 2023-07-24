<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>PWS Speedrun Statistics</title>
</head>
<body class="soft-blue">
    @include('components.other.overlay', ['nav' => 'hPowerwash', 'title' => 'PowerWash Sim Statistics'])
    <div class="container powerwash-container site-container">
        <div class="row pws-row">
            <div class="col-lg-6 col-xs-12">
                <h2>Any Equipment</h2>
                <div class="improvements-container">
                    @if (count($recentAeImprovements))
                        <p class="text-center">Placeholder</p>
                    @else
                        <p class="text-center">No improvements have been made.</p>
                    @endif
                </div>
                <h4 class="text-center">Total Time: {{$totalAeTime}}</h4>
            </div>
            <div class="col-lg-6 col-xs-12">
                <h2>Base Equipment</h2>
                <div class="improvements-container">
                    @if (count($recentAeImprovements))
                        <p class="text-center">Placeholder</p>
                    @else
                        <p class="text-center">No improvements have been made.</p>
                    @endif
                </div>
                <h4 class="text-center">Total Time: {{$totalBeTime}}</h4>
            </div>
        </div>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>