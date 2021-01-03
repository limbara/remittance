<?php

namespace App\Services\Api;

use App\Exceptions\Api\NotFoundException;
use App\Models\Country;

class CountryService
{
  /**
   * @param string $countryId
   * @return Country
   * @throws NotFoundException
   */
  public function find(string $countryId): Country
  {
    $country = Country::find($countryId);

    if (!$country) {
      throw new NotFoundException('Country Not Found');
    }

    return $country;
  }
}
