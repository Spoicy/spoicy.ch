<?php

namespace App\Console\Commands;

use App\Models\PowerwashCategory;
use App\Models\PowerwashRun;
use App\Models\PowerwashRunner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdatePowerwashRuns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pws:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for new 1st place times and adds them to the database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $limit = 100;
        $calls = 0;
        $categories = PowerwashCategory::all();
        foreach ($categories as $category) {
            if ($calls >= $limit) {
                // Find a different way to implement rate limits!!!!!!!!
                echo "Sleeping for 1 minute, Rate limit achieved.\n";
                sleep(60);
                $calls = 0;
            }
            // Make API request and setup data variables
            $request = Http::get("https://www.speedrun.com/api/v1/leaderboards/9do887e1/level/" . $category->levelId . "/" . $category->subcatId, [
                'var-e8m53zxn' => 'xqkv97nl',
                'var-gnxjxzgl' => 'p12k9xk1',
                'top' => 1,
                'embed' => 'players'
            ]);
            $calls++;
            if (count($request->object()->data->runs) < 1) {
                continue;
            }
            $runData = $request->object()->data->runs[0]->run;
            $playerData = $request->object()->data->players->data[0];
            $userId = $runData->players[0]->id;
            // Check if world record is still the same
            if (PowerwashRun::where('runId', $runData->id)->exists()) {
                continue;
            }
            // Create runner if not in database, else query runner
            if (!PowerwashRunner::where('userId', $userId)->exists()) {
                if ($playerData->{'name-style'}->style == 'solid') {
                    $colorFrom = $playerData->{'name-style'}->color->dark;
                    $colorTo = $playerData->{'name-style'}->color->dark;
                } else {
                    $colorFrom = $playerData->{'name-style'}->{'color-from'}->dark;
                    $colorTo = $playerData->{'name-style'}->{'color-to'}->dark;
                }
                $runner = PowerwashRunner::create([
                    'userId' => $userId,
                    'name' => $playerData->names->international,
                    'country' => $playerData->location->country->names->international,
                    'countryCode' => $playerData->location->country->code,
                    'colorFrom' => $colorFrom,
                    'colorTo' => $colorTo,
                    'pronouns' => $playerData->pronouns
                ]);
            } else {
                $runner = PowerwashRunner::where('userId', $userId)->first();
            }
            // Get order value and create new WR run
            $totalWRs = PowerwashRun::where('catId', $category->id)->count();
            $newRun = PowerwashRun::create([
                'catId' => $category->id,
                'runnerId' => $runner->id,
                'time' => $runData->times->primary_t * 1000,
                'date' => $runData->date,
                'order' => $totalWRs + 1,
                'runId' => $runData->id
            ]);
            echo "Added new WR for " . $category->name . " (" . (($category->subcatId == '824ngjnk') ? ('Any Equipment') : ('Base Equipment')) . 
                ") by " . $runner->name . " with a time of " . $newRun->time . "\n";
        }
        return 1;
    }
}
