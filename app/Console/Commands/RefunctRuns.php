<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefunctRuns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refunct:runs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all refunct runs and format into custom format';

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
        $getall = 0;
        $jsonstring = '[';
        $offset = 0;
        $variablename = "38d0zxl0";
        while (!$getall) {
            $runs = json_decode(file('https://www.speedrun.com/api/v1/runs?category=w20pq58k&embed=players&orderby=date&direction=asc&max=200&offset=' . $offset)[0])->data;
            if ($runs) {
                foreach ($runs as $run) {
                    if ($run->status->status == "verified" && $run->values->$variablename == "21d6v8pq") {
                        $newRun = new \stdClass();
                        if (isset($run->players->data[0]->names->international)) {
                            $newRun->name = $run->players->data[0]->names->international;
                            $newRun->pfp = $run->players->data[0]->assets->image->uri.'.png';
                        } else if (isset($run->players->data[0]->name)) {
                            $newRun->name = $run->players->data[0]->name;
                        } else {
                            $newRun->name = 'unknown';
                        }
                        if (isset($run->players->data[0]->location->country->code)) {
                            $newRun->country = $run->players->data[0]->location->country->code;
                        } else {
                            $newRun->country = 'xx';
                        }
                        if ($run->times->ingame_t != 0) {
                            $newRun->time = $run->times->ingame_t;
                        } else {
                            $newRun->time = $run->times->realtime_t;
                        }
                        $newRun->date = strtotime($run->date);
                        $jsonstring .= json_encode($newRun) . ",";
                    }
                }
            } else {
                $getall = 1;
            }
            $offset += 200;
        }
        $jsonstring .= ']';
        Storage::disk('local')->put('data.json', $jsonstring);
        return 0;
    }
}
