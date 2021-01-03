<?php

namespace Database\Factories;

use App\Enums\ProfileGender;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = UserProfile::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'first_name' => $this->faker->firstName,
      'last_name' => $this->faker->lastName,
      'birth_date' => $this->faker->date('Y-m-d', '2000-12-31'),
      'legal_identifier' => $this->faker->randomNumber(8) . '' . $this->faker->randomNumber(4),
      'address' => $this->faker->streetAddress,
      'gender' => $this->faker->boolean ? ProfileGender::MAN : ProfileGender::WOMAN,
      'photo' => $this->faker->image,
      'verified' => $this->faker->boolean,
    ];
  }
}
