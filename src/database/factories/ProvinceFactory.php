<?php

namespace Database\Factories;

use App\Enums\ProvinceStatus;
use App\Models\Country;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProvinceFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Province::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'province_name' => $this->faker->unique()->state,
      'status' => $this->faker->boolean(70) ? ProvinceStatus::ACTIVE : ProvinceStatus::INACTIVE,
      'country_id' => Country::factory()
    ];
  }

  public function active()
  {
    return $this->state(function () {
      return [
        'status' => ProvinceStatus::ACTIVE
      ];
    });
  }

  public function inactive()
  {
    return $this->state(function () {
      return [
        'status' => ProvinceStatus::INACTIVE
      ];
    });
  }
}
