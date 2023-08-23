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
        $categories = PowerwashCategory::all()
            ->keyBy('id');
        $runners = PowerwashRunner::all()->keyBy('id');
        $aeRuns = [];
        $beRuns = [];
        $bonusdlcRuns = [];
        $wrCareerHolders = [];
        $wrBonusdlcHolders = [];
        $totalAeTime = 0;
        $totalBeTime = 0;
        $totalOthers = new \stdClass();
        $totalOthersKeys = ['vehicleTime', 'locationTime', 'airTime', 'waterTime', 'landTime'];
        $totalBonusdlcTime = 0;
        $totalBonusTime = 0;
        $totalDlcTime = 0;
        $totalOtherDlc = new \stdClass();
        $totalOtherDlcKeys = [
            'tombraiderTime' => ['xd4lkg89', 'xd0846j9', 'rw6zm56d', 'n93rmzr9', 'z98xm41d'],
            'midgarTime' => ['495eg049', '69z1jv4w', 'rdqervgd', 'r9gp5o29', 'o9xjqv7d'],
            'spongebobTime' => ['xd1gonyd', 'ewpgvl4w', 'y9mlvn0w', '5wkyv3xd', '592x1y6d', '29vovqxw']
        ];
        foreach ($totalOthersKeys as $key) {
            $totalOthers->$key = 0;
        }
        foreach ($totalOtherDlcKeys as $key => $ids) {
            $totalOtherDlc->$key = 0;
        }
        foreach ($categories as $category) {
            $run = new \stdClass();
            $run->data = PowerwashRun::where('catId', $category->id)->orderby('order', 'desc')->first();
            $run->category = $category;
            if ($category->type == 'Vehicle' || $category->type == 'Location') {
                if (isset($run->data->time)) {
                    // Add time to Any Equip or Base Equip
                    if ($category->subcatId == '824ngjnk') {
                        $totalAeTime += $run->data->time;
                        // Add time to Vehicle or Location
                        if ($category->type == 'Vehicle') {
                            $totalOthers->vehicleTime += $run->data->time;
                            // Add time different vehicle subcategories
                            if (in_array($category->id, [29, 31, 33, 35])) {
                                $totalOthers->airTime += $run->data->time;
                            } else if (in_array($category->id, [25, 27])) {
                                $totalOthers->waterTime += $run->data->time;
                            } else {
                                $totalOthers->landTime += $run->data->time;
                            }
                        } else {
                            $totalOthers->locationTime += $run->data->time;
                        }
                    } else {
                        $totalBeTime += $run->data->time;
                    }
                }
                if (isset($run->data)) {
                    $run->runner = $runners->get($run->data->runnerId);
                    $name = $run->runner->name;
                    $nameKey = strtoupper($name);
                    if (!array_key_exists($nameKey, $wrCareerHolders)) {
                        $wrHolder = new \stdClass();
                        $wrHolder->player = $name;
                        $wrHolder->totalAe = 0;
                        $wrHolder->totalBe = 0;
                        $wrCareerHolders[$nameKey] = $wrHolder;
                    }
                    if ($category->subcatId == '824ngjnk') {
                        $wrCareerHolders[$nameKey]->totalAe++;
                    } else {
                        $wrCareerHolders[$nameKey]->totalBe++;
                    }
                }
                if ($category->subcatId == '824ngjnk') {
                    $aeRuns[$category->id] = $run;
                } else {
                    $beRuns[$category->id] = $run;
                }
            } else if ($category->type == 'Bonus' || $category->type == 'DLC') {
                if (isset($run->data->time)) {
                    $totalBonusdlcTime += $run->data->time;
                    // Add time to Vehicle or Location
                    if ($category->type == 'Bonus') {
                        $totalBonusTime += $run->data->time;
                    } else {
                        $totalDlcTime += $run->data->time;
                        foreach ($totalOtherDlcKeys as $key => $ids) {
                            if (in_array($category->levelId, $ids)) {
                                $totalOtherDlc->$key += $run->data->time;
                            }
                        } 
                    }
                }
                if (isset($run->data)) {
                    $run->runner = $runners->get($run->data->runnerId);
                    $name = $run->runner->name;
                    $nameKey = strtoupper($name);
                    if (!array_key_exists($nameKey, $wrBonusdlcHolders)) {
                        $wrHolder = new \stdClass();
                        $wrHolder->player = $name;
                        $wrHolder->total = 0;
                        $wrBonusdlcHolders[$nameKey] = $wrHolder;
                    }
                    $wrBonusdlcHolders[$nameKey]->total++;
                }
                $bonusdlcRuns[$category->id] = $run;
            }
        }
        // Recent improvements fetch
        $aeImprovementsQuery = PowerwashRun::select('powerwash_runs.*')
            ->join('powerwash_categories', 'powerwash_runs.catId', '=', 'powerwash_categories.id')
            ->where('powerwash_categories.subcatId', '824ngjnk')
            ->where(function ($query) {
                $query->where('powerwash_categories.type', 'Vehicle')
                    ->orWhere('powerwash_categories.type', 'Location');
            })
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
            ->where(function ($query) {
                $query->where('powerwash_categories.type', 'Vehicle')
                    ->orWhere('powerwash_categories.type', 'Location');
            })
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
        $bonusdlcImprovementsQuery = PowerwashRun::select('powerwash_runs.*')
            ->join('powerwash_categories', 'powerwash_runs.catId', '=', 'powerwash_categories.id')
            ->where(function($query) {
                $query->where('powerwash_categories.type', 'Bonus')
                    ->orWhere('powerwash_categories.type', 'DLC');
            })
            ->where('powerwash_runs.order', '>', 1)
            ->orderby('created_at', 'desc')->take(10)->get();
        $recentBonusdlcImprovements = [];
        foreach ($bonusdlcImprovementsQuery as $improvement) {
            $run = new \stdClass();
            $run->data = $improvement;
            $run->category = $categories->get($improvement->catId);
            $run->runner = $runners->get($improvement->runnerId);
            $deltaQuery = PowerwashRun::where('catId', $improvement->catId)->where('order', $improvement->order - 1)->first();
            $run->delta = SpeedrunHelper::getTimeFormat(($deltaQuery->time - $improvement->time) / 1000);
            $run->formattedTime = SpeedrunHelper::getTimeFormat($improvement->time / 1000);
            $recentBonusdlcImprovements[] = $run;
        }
        // Sort WR Totals by Player alphabetically.
        ksort($wrCareerHolders);
        ksort($wrBonusdlcHolders);
        // Round final number to a 60 frame compatible time for simplicity
        foreach ($totalOthersKeys as $key) {
            $totalOthers->$key = SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalOthers->$key) / 1000);
        }
        foreach ($totalOtherDlc as $key => $ids) {
            $totalOtherDlc->$key = SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalOtherDlc->$key) / 1000);
        }
        return view('pages/powerwash', [
            'aeRuns' => $aeRuns,
            'beRuns' => $beRuns,
            'bonusdlcRuns' => $bonusdlcRuns,
            'categories' => $categories,
            'totalAeTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalAeTime) / 1000),
            'totalBeTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalBeTime) / 1000),
            'totalOthers' => $totalOthers,
            'totalBonusdlcTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalBonusdlcTime) / 1000),
            'totalBonusTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalBonusTime) / 1000),
            'totalDlcTime' => SpeedrunHelper::getTimeFormat(SpeedrunHelper::roundTo60Frames($totalDlcTime) / 1000),
            'totalOtherDlc' => $totalOtherDlc,
            'recentAeImprovements' => $recentAeImprovements,
            'recentBeImprovements' => $recentBeImprovements,
            'recentBonusdlcImprovements' => $recentBonusdlcImprovements,
            'wrCareerHolders' => $wrCareerHolders,
            'wrBonusdlcHolders' => $wrBonusdlcHolders
        ]);
    }
}
