<?php

namespace App\Console\Commands;

use App\Models\PowerwashCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AddPowerwashLevels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pws:addlevels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds the base 38 levels to the database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $request = Http::get("https://www.speedrun.com/api/v1/games/9do887e1/levels");
        $requestData = $request->object()->data;
        if (PowerwashCategory::all()->count() > 0) {
            echo "Categories already exist in the table.\n";
            return Command::FAILURE;
        }
        for ($i = 0; $i < 38; $i++) {
            // Vehicles are ids 0-17, Locations are 18-37
            if ($i < 18) {
                $type = 'Vehicle';
            } else {
                $type = 'Location';
            }
            $aeCategory = PowerwashCategory::create([
                'levelId' => $requestData[$i]->id,
                'subcatId' => '824ngjnk',
                'varId' => 'xqkv97nl',
                'type' => $type,
                'name' => $requestData[$i]->name
            ]);
            $beCategory = PowerwashCategory::create([
                'levelId' => $requestData[$i]->id,
                'subcatId' => '9d8y4elk',
                'varId' => 'xqkv97nl',
                'type' => $type,
                'name' => $requestData[$i]->name
            ]);
        }
        return Command::SUCCESS;
    }
}
