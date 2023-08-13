<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Various stats about the PowerWash Simulator Speedrun Leaderboards.">
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>PWS Speedrun Statistics</title>
</head>
<body class="soft-blue">
    @include('components.other.overlay', ['nav' => 'hPowerwash', 'title' => 'PowerWash Sim Statistics'])
    <div class="container powerwash-container site-container">
        <div class="button-controls section-container">
            <button class="btn active" id="careerButton">Career</button>
            <button class="btn" id="bonusdlcButton">Bonus/DLC</button>
        </div>
        <div id="career">
            <div class="row pws-row">
                <div class="col-lg-6 col-xs-12 section-container ae-container">
                    <h2>Any Equipment</h2>
                    <div class="improvements-container">
                        @if (count($recentAeImprovements))
                            @foreach ($recentAeImprovements as $improvement)
                                <p class="text-center">
                                    <a href="https://www.speedrun.com/users/{{$improvement->runner->name}}" class="player-name" style="--color-from: {{$improvement->runner->colorFrom}}; --color-to: {{$improvement->runner->colorTo}};">{{$improvement->runner->name}}</a>
                                    has improved
                                    <b>{{$improvement->category->name}}</b>
                                    by
                                    <span class="delta">
                                        <span class="minus">- </span>
                                        {{$improvement->delta}}
                                    </span>
                                    with a
                                    <a href="https://www.speedrun.com/powerwash_simulator/runs/{{$improvement->data->runId}}" class="run-link">{{$improvement->formattedTime}}</a>.
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
                                    <a href="https://www.speedrun.com/users/{{$improvement->runner->name}}" class="player-name" style="--color-from: {{$improvement->runner->colorFrom}}; --color-to: {{$improvement->runner->colorTo}};">{{$improvement->runner->name}}</a>
                                    has improved
                                    <b>{{$improvement->category->name}}</b>
                                    by
                                    <span class="delta">
                                        <span class="minus">- </span>
                                        {{$improvement->delta}}
                                    </span>
                                    with a
                                    <a href="https://www.speedrun.com/powerwash_simulator/runs/{{$improvement->data->runId}}" class="run-link">{{$improvement->formattedTime}}</a>.
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
                    <h4>All Vehicles: {{$totalOthers->vehicleTime}}</h4>
                </div>
                <div class="col-lg-6 col-xs-12 text-center mb-3">
                    <h4>All Locations: {{$totalOthers->locationTime}}</h4>
                </div>
                <div class="col-lg-6 col-xs-12 text-center mb-3">
                    <h4>All Land Vehicles: {{$totalOthers->landTime}}</h4>
                </div>
                <div class="col-lg-6 col-xs-12 text-center mb-3">
                    <h4>All Water Vehicles: {{$totalOthers->waterTime}}</h4>
                </div>
                <div class="col-12 text-center mb-3">
                    <h4>All Air Vehicles: {{$totalOthers->airTime}}</h4>
                </div>
            </div>
            <div class="row pws-row wr-totals section-container">
                <div class="col-12">
                    <h2>World Record Totals</h2>
                </div>
                <div class="col-lg-3 d-lg-block d-none"></div>
                <div class="col-lg-6 col-xs-12">
                    <div class="wr-table">
                        <div class="row legend-row">
                            <div class="col-md-8 col-6">Players</div>
                            <div class="col-md-2 col-3">AE</div>
                            <div class="col-md-2 col-3">BE</div>
                        </div>
                        @foreach ($wrCareerHolders as $wrHolder)
                            <div class="row player-row">
                                <div class="col-md-8 col-6">{{$wrHolder->player}}</div>
                                <div class="col-md-2 col-3">{{$wrHolder->totalAe}}</div>
                                <div class="col-md-2 col-3">{{$wrHolder->totalBe}}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3 d-lg-block d-none"></div>
            </div>
        </div>
        <div id="bonusdlc" class="d-none">
            <div class="row pws-row">
                <div class="col-lg-6 col-xs-12 section-container dlcimp-container">
                    <h2>Bonus/DLC Improvements</h2>
                    <div class="improvements-container">
                        @if (count($recentBonusdlcImprovements))
                            @foreach ($recentBonusDlcImprovements as $improvement)
                                <p class="text-center">
                                    <a href="https://www.speedrun.com/users/{{$improvement->runner->name}}" class="player-name" style="--color-from: {{$improvement->runner->colorFrom}}; --color-to: {{$improvement->runner->colorTo}};">{{$improvement->runner->name}}</a>
                                    has improved
                                    <b>{{$improvement->category->name}}</b>
                                    by
                                    <span class="delta">
                                        <span class="minus">- </span>
                                        {{$improvement->delta}}
                                    </span>
                                    with a
                                    <a href="https://www.speedrun.com/powerwash_simulator/runs/{{$improvement->data->runId}}" class="run-link">{{$improvement->formattedTime}}</a>.
                                </p>
                            @endforeach
                        @else
                            <p class="text-center">No improvements have been made.</p>
                        @endif
                    </div>
                    <h4 class="text-center">Total Time: {{$totalBonusdlcTime}}</h4>
                </div>
                <div class="col-lg-6 col-xs-12 section-container">
                    <h2>Other Totals</h2>
                    <h4 class="text-center mb-4">All Bonus Levels: {{$totalBonusTime}}</h4>
                    <h4 class="text-center mb-4">All DLC Levels: {{$totalDlcTime}}</h4>
                    <h4 class="text-center mb-4">All Tomb Raider Levels: {{$totalOtherDlc->tombraiderTime}}</h4>
                    <h4 class="text-center mb-4">All Midgar Levels: {{$totalOtherDlc->tombraiderTime}}</h4>
                    <h4 class="text-center mb-4">All SpongeBob Levels: {{$totalOtherDlc->tombraiderTime}}</h4>
                </div>
            </div>
            <div class="row pws-row wr-bonusdlc-totals section-container">
                <div class="col-12">
                    <h2>World Record Totals</h2>
                </div>
                <div class="col-lg-3 d-lg-block d-none"></div>
                <div class="col-lg-6 col-xs-12">
                    <div class="wr-table">
                        <div class="row legend-row">
                            <div class="col-md-9 col-8">Players</div>
                            <div class="col-md-3 col-4">Records</div>
                        </div>
                        @foreach ($wrBonusdlcHolders as $wrHolder)
                            <div class="row player-row">
                                <div class="col-md-9 col-8">{{$wrHolder->player}}</div>
                                <div class="col-md-3 col-4">{{$wrHolder->total}}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3 d-lg-block d-none"></div>
            </div>
        </div>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>