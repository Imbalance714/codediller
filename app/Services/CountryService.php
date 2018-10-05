<?php
/**
 * Created by PhpStorm.
 * User: Imbalance
 * Date: 03.10.2018
 * Time: 16:36
 */

namespace App\Services;
use App\Models\Countries;

/**
 * Class CountryService
 * @package App\Services
 */
class CountryService
{
    /**
     * @param $countryName
     * @return mixed
     */
    public function createIfNotExist($countryName) {
        return  Countries::firstOrCreate(['name' => $countryName]);
    }
}