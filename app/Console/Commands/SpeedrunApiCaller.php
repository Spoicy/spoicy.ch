<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SpeedrunApiCaller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'srdc:apicaller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expanded API Caller for features not possible in current API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $request = Http::get("https://www.speedrun.com/api/v1/runs", [
            'user' => 'xkmpg06j',
            'game' => '9d0887e1',
            'orderby' => 'date',
            'direction' => 'asc',
            'max' => 200
        ]);
        $totalOfCategory = 0;
        foreach ($request->object()->data as $run) {
            if ($run->category == '02q43m9d') {
                $totalOfCategory++;
            }
        }
        echo "Total runs of Old Any Equip: $totalOfCategory\n";
        return Command::SUCCESS;
    }
}
