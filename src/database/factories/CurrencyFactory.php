<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Currency::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $currencyCode = $this->faker->unique()->currencyCode;

    return [
      'currency_code' => $currencyCode,
      'currency_name' => "{$currencyCode} currency",
      'currency_symbol_unicode' => 'U+0024',
      'minor_unit' => $this->faker->numberBetween(0, 3),
      'transaction_fee' => 5,
      'transaction_minimum_amount' => $this->faker->randomDigit,
      'transaction_maximum_amount' => 1000,
      'country_id' => Country::factory()
    ];
  }
}
