<?php

namespace Database\Factories;

use App\Models\UserPointHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserPointHistoryFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = UserPointHistory::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'description' => $this->faker->sentence,
      'type' => $this->faker->boolean,
      'amount' => $this->faker->numberBetween(1, 100),
      'created_at' => $this->faker->dateTimeBetween('-30 days')
    ];
  }
}
