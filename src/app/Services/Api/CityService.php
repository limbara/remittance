<?php

namespace App\Services\Api;

use App\Exceptions\Api\NotFoundException;
use App\Models\City;

class CityService
{
  /**
   * find City
   * 
   * @param int $cityId
   * @return City 
   * @throws NotFoundException
   */
  public function find(int $cityId): City
  {
    $city = City::find($cityId);

    if (!$city) {
      throw new NotFoundException('City Not Found');
    }

    return $city;
  }
}
