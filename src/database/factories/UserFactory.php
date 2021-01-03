<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = User::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'phone_number' => $this->faker->phoneNumber,
      'email' => $this->faker->freeEmail,
      'point' => $this->faker->boolean(60) ? $this->faker->randomNumber(3) : $this->faker->randomNumber(2),
    ];
  }
}
