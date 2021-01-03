<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Province;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Country::factory()->count(10)->has(
      Province::factory()->count(3)->has(
        City::factory(2)
      )
    )->has(
      Bank::factory()->count(2)
    )->create();
  }
}
