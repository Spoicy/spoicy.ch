<?php

namespace App\Console\Commands;

use App\Helpers\PowerwashHelper;
use App\Models\PowerwashCategory;
use App\Models\PowerwashRun;
use App\Models\PowerwashRunner;
use App\Models\SuccessfulJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdatePowerwashBonusDlcRuns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pws:updatedlc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for new 1st place times for Bonus/DLC categories and adds them to the database.';

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
        $newRunsCount = 0;
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
            // Create runner if not in database, else query for runner
            if (!PowerwashRunner::where('userId', $userId)->exists()) {
                $runner = PowerwashHelper::createRunner($userId, $playerData);
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
            echo "Added new WR for " . $category->name . " by " . $runner->name . " with a time of " . $newRun->time . "\n";
            $newRunsCount++;
        }
        SuccessfulJob::create([
            'job_name' => 'pws:updatedlc',
            'info' => "$newRunsCount new runs added"
        ]);
        return Command::SUCCESS;
    }
}
