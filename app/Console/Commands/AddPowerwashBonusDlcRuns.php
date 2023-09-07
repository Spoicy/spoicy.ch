<?php

namespace App\Console\Commands;

use App\Helpers\PowerwashHelper;
use App\Models\PowerwashCategory;
use App\Models\PowerwashRun;
use App\Models\PowerwashRunner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AddPowerwashBonusDlcRuns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pws:addrunsdlc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds all current bonus/dlc level WRs to the database if table is empty.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $limit = 100;
        $calls = 0;
        $categories = PowerwashCategory::where('type', 'Bonus')
            ->orWhere('type', 'DLC')
            ->get();
        foreach ($categories as $category) {
            if (PowerwashRun::where('catId', $category->id)->exists()) {
                continue;
            }
            if ($calls >= $limit) {
                echo "Sleeping for 1 minute, Rate limit achieved.\n";
                sleep(60);
                $calls = 0;
            }
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
            if (!PowerwashRunner::where('userId', $userId)->exists()) {
                $runner = PowerwashHelper::createRunner($userId, $playerData);
            } else {
                $runner = PowerwashRunner::where('userId', $userId)->first();
            }
            $newRun = PowerwashRun::create([
                'catId' => $category->id,
                'runnerId' => $runner->id,
                'time' => $runData->times->primary_t * 1000,
                'date' => $runData->date,
                'order' => 1,
                'runId' => $runData->id
            ]);
            echo "Added run " . $category->name . " (" . PowerwashHelper::getSubcategoryName($category->subcatId) .
                ") by " . $runner->name . " with a time of " . $newRun->time . "\n";
        }
        return Command::SUCCESS;
    }
}
