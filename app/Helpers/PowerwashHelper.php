<?php

namespace App\Helpers;

class PowerwashHelper
{
    /**
     * Fetches the subcategory name based on id.
     * 
     * @param  string $subcatId
     * @return string $subcategoryName
     */
    public static function getSubcategoryName(string $subcatId): string
    {
        return (($subcatId == '824ngjnk') ? ('Any Equipment') : ('Base Equipment'));
    }
}
