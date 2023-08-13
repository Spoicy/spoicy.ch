<?php

namespace App\Console\Commands;

use App\Models\PowerwashCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AddPowerwashBonusDlcLevels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pws:addlevelsdlc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds the bonus/dlc levels to the database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $request = Http::get("https://www.speedrun.com/api/v1/games/9do887e1/levels");
        $requestData = $request->object()->data;
        for ($i = 38; $i < count($requestData); $i++) {
            if (PowerwashCategory::where('levelId', $requestData[$i]->id)->exists()) {
                continue;
            }
            // Bonus levels always start with Clean the or Clean The
            if (str_contains($requestData[$i]->name, 'Clean the') || str_contains($requestData[$i]->name, 'Clean The')) {
                $type = 'Bonus';
            } else {
                $type = 'DLC';
            }
            $category = PowerwashCategory::create([
                'levelId' => $requestData[$i]->id,
                'subcatId' => '824ngjnk',
                'varId' => 'xqkv97nl',
                'type' => $type,
                'name' => $requestData[$i]->name
            ]);
            echo "Added new " . $type . " Level: " . $requestData[$i]->name . "\n";
            if ($requestData[$i]->id == 'rw613e79') {
                $beCategory = PowerwashCategory::create([
                    'levelId' => $requestData[$i]->id,
                    'subcatId' => '9d8y4elk',
                    'varId' => 'xqkv97nl',
                    'type' => $type,
                    'name' => $requestData[$i]->name . " (BE)"
                ]);
                echo "Added new Mars Rover's BE category\n";
            }
        }
        return 1;
    }
}
