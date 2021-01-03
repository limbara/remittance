<?php

namespace Database\Factories;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoucherFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Voucher::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'point_cost' => $this->faker->boolean(60) ? $this->faker->randomNumber(2) : $this->faker->randomNumber(3),
      'valid_from' => $this->faker->dateTimeBetween('-30 days'),
      'valid_to' => $this->faker->dateTimeBetween('now ', '+30 days'),
    ];
  }
}
