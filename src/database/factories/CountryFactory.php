<?php

namespace Database\Factories;

use App\Enums\CountryStatus;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Country::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $country = $this->faker->unique()->countryCode;

    return [
      'country_name' => $country . ' country',
      'country_code' => $country,
      'country_flag_unicode' => preg_replace_callback('/./', function ($matches) {
        return 'U+' . strtoupper(dechex(ord($matches[0]) + 127397));
      }, $country),
      'status' => $this->faker->boolean(70) ? CountryStatus::ACTIVE : CountryStatus::INACTIVE,
    ];
  }

  public function active()
  {
    return $this->state(function () {
      return [
        'status' => CountryStatus::ACTIVE
      ];
    });
  }

  public function inactive()
  {
    return $this->state(function () {
      return [
        'status' => CountryStatus::INACTIVE
      ];
    });
  }
}
