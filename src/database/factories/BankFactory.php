<?php

namespace Database\Factories;

use App\Enums\BankStatus;
use App\Models\Bank;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Bank::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->company . ' Bank',
      'status' => $this->faker->boolean(70) ? BankStatus::ACTIVE : BankStatus::INACTIVE,
      'country_id' => Country::factory()
    ];
  }

  public function active()
  {
    return $this->state(function () {
      return [
        'status' => BankStatus::ACTIVE
      ];
    });
  }

  public function inactive()
  {
    return $this->state(function () {
      return [
        'status' => BankStatus::INACTIVE
      ];
    });
  }
}
