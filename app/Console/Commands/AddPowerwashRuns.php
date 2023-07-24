<?php

namespace App\Console\Commands;

use App\Models\PowerwashCategory;
use App\Models\PowerwashRun;
use App\Models\PowerwashRunner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AddPowerwashRuns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pws:addruns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds all current level WRs to the database if table is empty.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (PowerwashRun::all()->count() > 0) {
            echo "Runs already exist in the database.\n";
            return 0;
        }
        $limit = 100;
        $calls = 0;
        $categories = PowerwashCategory::all();
        foreach ($categories as $category) {
            if ($calls >= $limit) {
                echo "Sleeping for 1 minute, Rate limit achieved.\n";
                sleep(60);
                $calls = 0;
            }
            $request = Http::get("https://www.speedrun.com/api/v1/leaderboards/9do887e1/level/".$category->levelId."/".$category->subcatId, [
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
            $newRun = PowerwashRun::create([
                'catId' => $category->id,
                'runnerId' => $runner->id,
                'time' => $runData->times->primary_t,
                'date' => $runData->date,
                'order' => 1,
                'runId'=> $runData->id
            ]);
        }
        return 1;
    }
}
