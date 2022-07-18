<?php

namespace App\Console\Commands;

use App\Models\Speedrun;
use Illuminate\Console\Command;

class AddTypesToSpeedruns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'srdc:addtypes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to add types to the existing imported speedruns. Use in conjunction with maintenance mode if required.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $speedruns = Speedrun::all();
        $limit = 100;
        $i = 0;
        foreach ($speedruns as $speedrun) {
            if (!$speedrun->type && $i < $limit) {
                try {
                    $i++;
                    $apicall = json_decode(file('https://www.speedrun.com/api/v1/runs/' . $speedrun->sid . '?embed=level')[0])->data;
                } catch (\Exception $e) {
                    continue;
                }
                if ($apicall->level->data) {
                    $speedrun->type = "level";
                } else {
                    $speedrun->type = "fullgame";
                }
                $speedrun->save();
            }
        }
        return 0;
    }
}
