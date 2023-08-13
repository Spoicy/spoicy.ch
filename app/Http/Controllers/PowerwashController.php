<?php

namespace App\Http\Controllers;

use App\Helpers\SpeedrunHelper;
use App\Models\PowerwashCategory;
use App\Models\PowerwashRun;
use App\Models\PowerwashRunner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PowerwashController extends Controller
{
    /**
     * Prepares all of the necessary data for the stream component templates.
     * 
     * @return View $page
     */
    public static function view(): \Illuminate\Contracts\View\View
    {
        $categories = PowerwashCategory::where('type', 'Vehicle')
            ->orWhere('type', 'Location')
            ->get()
            ->keyBy('id');
        $runners = PowerwashRunner::all()->keyBy('id');
        $aeRuns = [];
        $beRuns = [];
        $wrHolders = [];
        $totalAeTime = 0;
        $totalBeTime = 0;
        $totalVehicleTime = 0;
        $totalLocationTime = 0;
        $totalAirTime = 0;
        $totalWaterTime = 0;
        $totalLandTime = 0;
        foreach ($categories as $category) {
            $run = new \stdClass();
            $run->data = PowerwashRun::where('catId', $category->id)->orderby('order', 'desc')->first();
            $run->category = $category;
            if (isset($run->data->time)) {
                // Add time to Any Equip or Base Equip
                if ($category->subcatId == '824ngjnk') {
                    $totalAeTime += $run->data->time;
                    // Add time to Vehicle or Location
                    if ($category->type == 'Vehicle') {
                        $totalVehicleTime += $run->data->time;
                        // Add time different vehicle subcategories
                        if (in_array($category->id, [29, 31, 33, 35])) {
                            $totalAirTime += $run->data->time;
                        } else if (in_array($category->id, [25, 27])) {
                            $totalWaterTime += $run->data->time;
                        } else {
                            $totalLandTime += $run->data->time;
                        }
                    } else {
                        $totalLocationTime += $run->data->time;
                    }
                } else {
                    $totalBeTime += $run->data->time;
                }
                
            }
            if (isset($run->data)) {
                $run->runner = $runners->get($run->data->runnerId);
                $name = $run->runner->name;
                $nameKey = strtoupper($name);
                if (!array_key_exists($nameKey, $wrHolders)) {
                    $wrHolder = new \stdClass();
                    $wrHolder->player = $name;
                    $wrHolder->totalAe = 0;
                    $wrHolder->totalBe = 0;
                    $wrHolders[$nameKey] = $wrHolder;
                }
                if ($category->subcatId == '824ngjnk') {
                    $wrHolders[$nameKey]->totalAe++;
                } else {
                    $wrHolders[$nameKey]->totalBe++;
                }
            }
            if ($category->subcatId == '824ngjnk') {
                $aeRuns[$category->id] = $run;
            } else {
                $beRuns[$category->id] = $run;
            }
        }
        // Recent improvements fetch
        $aeImprovementsQuery = PowerwashRun::select('powerwash_runs.*')
            ->join('powerwash_categories', 'powerwash_runs.catId', '=', 'powerwash_categories.id')
            ->where('powerwash_categories.subcatId', '824ngjnk')
            ->where('powerwash_runs.order', '>', 1)
            ->orderby('created_at', 'desc')->take(10)->get();
        $recentAeImprovements = [];
        foreach ($aeImprovementsQuery as $improvement) {
            $run = new \stdClass();
            $run->data = $improvement;
            $run->category = $categories->get($improvement->catId);
            $run->runner = $runners->get($improvement->runnerId);
            $deltaQuery = PowerwashRun::where('catId', $improvement->catId)->where('order', $improvement->order - 1)->first();
            $run->delta = SpeedrunHelper::getTimeFormat(($deltaQuery->time - $improvement->time) / 1000);
            $run->formattedTime = SpeedrunHelper::getTimeFormat($improvement->time / 1000);
            $recentAeImprovements[] = $run;
        }
        $beImprovementsQuery = PowerwashRun::select('powerwash_runs.*')
            ->join('powerwash_categories', 'powerwash_runs.catId', '=', 'powerwash_categories.id')
            ->where('powerwash_categories.subcatId', '9d8y4elk')
            ->where('powerwash_runs.order', '>', 1)
            ->orderby('created_at', 'desc')->take(10)->get();
        $recentBeImprovements = [];
        foreach ($beImprovementsQuery as $improvement) {
            $run = new \stdClass();
            $run->data = $improvement;
            $run->category = $categories->get($improvement->catId);
            $run->runner = $runners->get($improvement->runnerId);
            $deltaQuery = PowerwashRun::where('catId', $improvement->catId)->where('order', $improvement->order - 1)->first();
            $run->delta = SpeedrunHelper::getTimeFormat(($deltaQuery->time - $improvement->time) / 1000);
            $run->formattedTime = SpeedrunHelper::getTimeFormat($improvement->time / 1000);
            $recentBeImprovements[] = $run;
        }
        // Sort WR Totals by Player alphabetically.
        ksort($wrHolders);
        // Round final number to a 60 frame compatible time for simplicity
        return view('pages/powerwash', [
            'aeRuns' => $aeRuns,
            'beRuns' => $beRuns,
            'categories' => $categories,
            'totalAeTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalAeTime) / 1000),
            'totalBeTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalBeTime) / 1000),
            'totalVehicleTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalVehicleTime) / 1000),
            'totalLocationTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalLocationTime) / 1000),
            'totalLandTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalLandTime) / 1000),
            'totalWaterTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalWaterTime) / 1000),
            'totalAirTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalAirTime) / 1000),
            'recentAeImprovements' => $recentAeImprovements,
            'recentBeImprovements' => $recentBeImprovements,
            'wrHolders' => $wrHolders
        ]);
    }
}
