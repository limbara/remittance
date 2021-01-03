<?php

namespace Database\Factories;

use App\Enums\CityStatus;
use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = City::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'city_name' => $this->faker->unique()->city,
      'status' => $this->faker->boolean(70) ? CityStatus::ACTIVE : CityStatus::INACTIVE,
      'province_id' => Province::factory()
    ];
  }

  public function active()
  {
    return $this->state(function () {
      return [
        'status' => CityStatus::ACTIVE
      ];
    });
  }

  public function inactive()
  {
    return $this->state(function () {
      return [
        'status' => CityStatus::INACTIVE
      ];
    });
  }
}
