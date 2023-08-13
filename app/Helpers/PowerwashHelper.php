<?php

namespace App\Helpers;

use App\Models\PowerwashRunner;

class PowerwashHelper
{
    /**
     * Fetches the subcategory name based on id.
     * 
     * @param  string $subcatId
     * @return string $subcategoryName
     */
    public static function getSubcategoryName(string $subcatId): string {
        return (($subcatId == '824ngjnk') ? ('Any Equipment') : ('Base Equipment'));
    }

    public static function createRunner(string $userId, \stdClass $runnerData): PowerwashRunner {
        if (!PowerwashRunner::where('userId', $userId)->exists()) {
            if ($runnerData->{'name-style'}->style == 'solid') {
                $colorFrom = $runnerData->{'name-style'}->color->light;
                $colorTo = $runnerData->{'name-style'}->color->light;
            } else {
                $colorFrom = $runnerData->{'name-style'}->{'color-from'}->light;
                $colorTo = $runnerData->{'name-style'}->{'color-to'}->light;
            }
            $runner = PowerwashRunner::create([
                'userId' => $userId,
                'name' => $runnerData->names->international,
                'country' => $runnerData->location->country->names->international,
                'countryCode' => substr($runnerData->location->country->code, 0, 2),
                'colorFrom' => $colorFrom,
                'colorTo' => $colorTo,
                'pronouns' => $runnerData->pronouns
            ]);
        } else {
            $runner = PowerwashRunner::where('userId', $userId)->first();
        }
        return $runner;
    }
}
