<?php

namespace App\Console\Commands;

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
        Schema::create('tmp_speedruns', function ($table) {
            $table->increments('id');
            $table->string('game', 255);
            $table->string('game_link', 255);
            $table->string('category', 255);
            $table->string('category_link', 255);
            $table->date('date');
            $table->float('time');
            $table->string('image', 255);
        });
        $tableTmpSpeedruns = DB::table('tmp_speedruns');

        $speedruns = json_decode(file("https://www.speedrun.com/api/v1/runs?user=kj9407x4&orderby=submitted&direction=desc")[0])->data;
        foreach ($speedruns as $key => $speedrun) {
            $speedrunLinks = array();
            foreach ($speedrun->links as $link) {
                $speedrunLinks[$link->rel] = $link->uri;
            }
            $game = json_decode(file($speedrunLinks["game"])[0])->data;
            $category = json_decode(file($speedrunLinks["category"])[0])->data;
            $categoryLinks = array();
            foreach ($category->links as $link) {
                $categoryLinks[$link->rel] = $link->uri;
            }
            $category_weblink = $category->weblink;
            if (in_array("variables", array_keys($categoryLinks))) {
                $variables = json_decode(file($categoryLinks["variables"])[0])->data;
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
            if (in_array("level", array_keys($speedrunLinks))) {
                $level = json_decode(file($speedrunLinks["level"])[0])->data;
                $levelCategories = json_decode(file($level->links[2]->uri)[0])->data;
                foreach ($levelCategories as $levelKey => $levelcategory) {
                    if ($levelcategory->id == $category->id) {
                        $category_weblink = $levelcategory->weblink;
                    }
                }
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
            $tableTmpSpeedruns->insert(
                [
                    'game' => $game->names->international,
                    'game_link' => $game->weblink,
                    'category' => $category_name,
                    'category_link' => $category_weblink,
                    'date' => $date,
                    'time' => $time,
                    'image' => $logo
                ]
            );
        }
        Schema::dropIfExists('speedruns');
        Schema::rename('tmp_speedruns', 'speedruns');
        return 0;
    }
}
