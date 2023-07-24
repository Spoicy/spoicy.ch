<?php

namespace App\Http\Controllers;

use App\Helpers\SpeedrunHelper;
use App\Models\PowerwashCategory;
use App\Models\PowerwashRun;
use App\Models\PowerwashRunner;
use Illuminate\Http\Request;

class PowerwashController extends Controller
{
    /**
     * Prepares all of the necessary data for the stream component templates.
     * 
     * @return View $page
     */
    public static function view(): \Illuminate\Contracts\View\View
    {
        $categories = PowerwashCategory::all();
        $runs = [];
        $totalAeTime = 0;
        $totalBeTime = 0;
        foreach ($categories as $category) {
            $run = new \stdClass();
            $run->data = PowerwashRun::where('catId', $category->id)->orderby('order', 'desc')->first();
            if (isset($run->data->time)) {
                if ($category->subcatId == '824ngjnk') {
                    $totalAeTime += $run->data->time;
                } else {
                    $totalBeTime += $run->data->time;
                }
            }
            if (isset($run->data)) {
                $run->runner = PowerwashRunner::where('id', $run->data->runnerId);
            }
            $runs[$category->id] = $run;
        }
        // Round final number to a 60 frame compatible time for simplicity
        
        return view('pages/powerwash', [
            'runs' => $runs,
            'categories' => $categories,
            'totalAeTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalAeTime) / 1000),
            'totalBeTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalBeTime) / 1000),
            'recentAeImprovements' => PowerwashRun::select('powerwash_runs.*')
                ->join('powerwash_categories', 'powerwash_runs.catId', '=', 'powerwash_categories.id')
                ->where('powerwash_categories.subcatId', '824ngjnk')
                ->where('powerwash_runs.order', '>', 1)
                ->orderby('date', 'desc')->get(),
            'recentBeImprovements' => PowerwashRun::select('powerwash_runs.*')
                ->join('powerwash_categories', 'powerwash_runs.catId', '=', 'powerwash_categories.id')
                ->where('powerwash_categories.subcatId', '9d8y4elk')
                ->where('powerwash_runs.order', '>', 1)
                ->orderby('date', 'desc')->get(),
        ]);
    }
}
