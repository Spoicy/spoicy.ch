<?php

namespace App\Console\Commands;

use App\Models\Speedrun;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateSRDC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'srdc:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grabs the latest run data from the SRDC Profile';

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
        if (!Schema::hasTable('speedruns')) {
            die("No table found, please run migrations first.");
        }

        $query = Speedrun::all();
        $sids = array();
        
        foreach ($query as $result) {
            $sids[] = $result->sid;
        }

        $speedruns = array_reverse(json_decode(file("https://www.speedrun.com/api/v1/runs?embed=game,category,level&user=kj9407x4&orderby=submitted&direction=desc&max=30")[0])->data);
        foreach ($speedruns as $key => $speedrun) {
            // TODO make this more efficient by utilizing less API calls
            if (!in_array($speedrun->id, $sids) && $speedrun->status->status == "verified") {
                $speedrunLinks = array();
                foreach ($speedrun->links as $link) {
                    $speedrunLinks[$link->rel] = $link->uri;
                }
                $game = $speedrun->game->data;
                if (!isset($speedrun->category->data)) {
                    continue;
                }
                $category = $speedrun->category->data;
                $categoryLinks = array();
                foreach ($category->links as $link) {
                    $categoryLinks[$link->rel] = $link->uri;
                }
                $category_weblink = $category->weblink;
                if (in_array("variables", array_keys($categoryLinks))) {
                    try {
                        $variables = json_decode(file($categoryLinks["variables"])[0])->data;
                    } catch (\Exception $e) {
                        echo "Error with variable fetch: " . $e->getMessage();
                        continue;
                    }
                    if (count($variables)) {
                        $variables = $variables[0];
                    } else {
                        unset($variables);
                    }
                }
                $variableLabel = null;
                if (isset($variables) && $variables->{'is-subcategory'}) {
                    $key = $variables->id;
                    if (isset($speedrun->values->$key)) {
                        $variable = $speedrun->values->$key;
                        $variableLabel = $variables->values->values->{"$variable"}->label;
                    }
                }
                $level = null;
                if ($speedrun->level->data) {
                    $type = 'level';
                    $level = $speedrun->level->data;
                    $levelCategories = json_decode(file($level->links[2]->uri)[0])->data;
                    foreach ($levelCategories as $levelKey => $levelcategory) {
                        if ($levelcategory->id == $category->id) {
                            $category_weblink = $levelcategory->weblink;
                        }
                    }
                } else {
                    $type = 'fullgame';
                }
                $logo = $game->assets->{'cover-medium'}->uri;
                $time = $speedrun->times->primary_t;
                $category_name = "";
                if ($level) {
                    $category_name .= $level->name . ": ";
                }
                $category_name .= $category->name;
                if ($variableLabel) {
                    $category_name .= " - " . $variableLabel;
                }
                $date = $speedrun->date;
                //inserts
                $newSpeedrun = Speedrun::create([
                    'sid' => $speedrun->id,
                    'game' => $game->names->international,
                    'game_link' => $game->weblink,
                    'category' => $category_name,
                    'category_link' => $category_weblink,
                    'date' => $date,
                    'time' => $time,
                    'image' => $logo,
                    'type' => $type
                ]);
            }
        }
        return 0;
    }
}
