<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $countries = Country::all();

    $currencies = $countries->map(function (Country $country) {
      return Currency::factory()->create([
        'country_id' => $country->id
      ]);
    });

    foreach ($currencies as $currencyFrom) {
      foreach ($currencies as $currencyTo) {
        $cFrom = $currencyFrom->currency_code;
        $cTo = $currencyTo->currency_code;

        if ($cFrom !== $cTo) {
          ExchangeRate::factory(10)->create([
            'currency_from' => $cFrom,
            'currency_to' => $cTo
          ]);
        }
      }
    }
  }
}
