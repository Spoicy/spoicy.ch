<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class BuffedTridentMove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pws:buffedmove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Moves Buffed Trident runs to main boards.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Command disable, one time use only
        return Command::SUCCESS;
        $mainrequest = Http::get("https://www.speedrun.com/api/v1/games/9do887e1/levels");
        $mainlevelids = [];

        foreach ($mainrequest->object()->data as $level) {
            $mainlevelids[] = $level->id;
        }

        $cerequest = Http::get("https://www.speedrun.com/api/v1/games/k6qpw29d/levels");
        
        $levelruns = [];
        $i = 0;
        $runCount = 0;
        foreach ($cerequest->object()->data as $level) {
            
            $runRequest = Http::get("https://www.speedrun.com/api/v1/leaderboards/k6qpw29d/level/" . $level->id . "/zdn3pj72");
            $runs = $runRequest->object()->data->runs;
            $levelruns[$mainlevelids[$i]] = [];
            if (!count($runs)) {
                $i++;
                continue;
            }
            foreach ($runs as $runObj) {
                $run = $runObj->run;
                $runData = new \stdClass();
                $runData->category = "824ngjnk";
                $runData->level = $mainlevelids[$i];
                $runData->date = $run->date;
                $runData->platform = $run->system->platform;
                $runData->verified = true;
                $runData->times = new \stdClass();
                $runData->times->realtime = $run->times->realtime_t;
                $player = new \stdClass();
                $player->rel = "user";
                $player->id = $run->players[0]->id;
                $runData->players = [$player];
                $runData->emulated = false;
                $runData->video = $run->videos->links[0]->uri;
                $runData->comment = "Run moved over from Category Extensions.";
                $variables = new \stdClass();
                $variableVersion = new \stdClass();
                $variableVersion->type = "pre-defined";
                $variableVersion->value = "10v04kwl";
                $variableFreePlay = new \stdClass();
                $variableFreePlay->type = "pre-defined";
                $variableFreePlay->value = "p12k9xk1";
                $variables->e8m53zxn = $variableVersion;
                $variables->gnxjxzgl = $variableFreePlay;
                $runData->variables = $variables;
                $runToAdd = new \stdClass();
                $runToAdd->run = $runData;
                $levelruns[$mainlevelids[$i]][] = $runToAdd;
                $runCount++;
            }
            $i++;
        }
        echo "Total runs collected: $runCount\r\n";
        sleep(60);
        $submitCount = 0;
        foreach ($mainlevelids as $mainlevel) {
            foreach ($levelruns[$mainlevel] as $run) {
                $request = Http::withHeaders(['X-API-Key' => env('SRDC_API_KEY')])->withBody(json_encode($run), 'application/json')->post('https://www.speedrun.com/api/v1/runs');
                $submitCount++;
            } 
        }
        echo "Total runs submitted: $submitCount\r\n";
        //$request = Http::withHeaders(['X-API-Key' => env('SRDC_API_KEY')])->withBody(json_encode($levelruns['xd41xnrd'][0]), 'application/json')->post('https://www.speedrun.com/api/v1/runs');
        Storage::disk('local')->put('pwsruns.json', json_encode($levelruns));
        return Command::SUCCESS;
    }
}
