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
            <div class="col-lg-6 col-xs-12 section-container ae-container">
                <h2>Any Equipment</h2>
                <div class="improvements-container">
                    @if (count($recentAeImprovements))
                        @foreach ($recentAeImprovements as $improvement)
                            <p class="text-center">
                                <b>{{$improvement->runner->name}}</b>
                                has improved
                                <b>{{$improvement->category->name}}</b>
                                by
                                <span class="delta">
                                    <span class="minus">- </span>
                                    {{$improvement->delta}}
                                </span>
                                with a
                                <b>{{$improvement->formattedTime}}</b>.
                            </p>
                        @endforeach
                    @else
                        <p class="text-center">No improvements have been made.</p>
                    @endif
                </div>
                <h4 class="text-center">Total Time: {{$totalAeTime}}</h4>
            </div>
            <div class="col-lg-6 col-xs-12 section-container be-container">
                <h2>Base Equipment</h2>
                <div class="improvements-container">
                    @if (count($recentBeImprovements))
                        @foreach ($recentBeImprovements as $improvement)
                            <p class="text-center">
                                <b>{{$improvement->runner->name}}</b>
                                has improved
                                <b>{{$improvement->category->name}}</b>
                                by
                                <span class="delta">
                                    <span class="minus">- </span>
                                    {{$improvement->delta}}
                                </span>
                                with a
                                <b>{{$improvement->formattedTime}}</b>.
                            </p>
                        @endforeach
                    @else
                        <p class="text-center">No improvements have been made.</p>
                    @endif
                </div>
                <h4 class="text-center">Total Time: {{$totalBeTime}}</h4>
            </div>
        </div>
        <div class="row pws-row other-totals section-container">
            <div class="col-12">
                <h2>Other Totals</h2>
            </div>
            <div class="col-lg-6 col-xs-12 text-center mb-3">
                <h4>All Vehicles: {{$totalVehicleTime}}</h4>
            </div>
            <div class="col-lg-6 col-xs-12 text-center mb-3">
                <h4>All Locations: {{$totalLocationTime}}</h4>
            </div>
            <div class="col-lg-6 col-xs-12 text-center mb-3">
                <h4>All Land Vehicles: {{$totalLandTime}}</h4>
            </div>
            <div class="col-lg-6 col-xs-12 text-center mb-3">
                <h4>All Water Vehicles: {{$totalWaterTime}}</h4>
            </div>
            <div class="col-12 text-center mb-3">
                <h4>All Air Vehicles: {{$totalAirTime}}</h4>
            </div>
        </div>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>