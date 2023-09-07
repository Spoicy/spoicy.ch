<?php

namespace App\Console\Commands;

use App\Models\Speedrun;
use Illuminate\Console\Command;

class UpdateSpeedrunImageUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'srdc:updateimages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update speedrun game covers to the new URL format';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $speedruns = Speedrun::all();
        foreach ($speedruns as $speedrun) {
            if (!str_contains($speedrun->image, "gameasset")) {
                continue;
            }
            $splitString = explode("/cover?v=", $speedrun->image);
            $version = $splitString[1];
            $gameId = explode("gameasset/", $splitString[0])[1];
            $speedrun->image = "https://www.speedrun.com/static/game/" . $gameId . "/cover.png?v=" . $version;
            $speedrun->save();
        }
        return Command::SUCCESS;
    }
}
