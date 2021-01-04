<?php

namespace Database\Seeders;

use App\Enums\BankStatus;
use App\Enums\CityStatus;
use App\Enums\CountryStatus;
use App\Enums\ProvinceStatus;
use App\Models\Bank;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Models\Province;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call([
      CountrySeeder::class,
      CurrencySeeder::class,
      VoucherSeeder::class,
      UserSeeder::class,
      RelationshipSeeder::class,
      NotificationSeeder::class,
      TransactionRequirementSeeder::class,
      PaymentMethodSeeder::class,
    ]);

    $countryID = Country::factory()->create([
      'country_code' => 'ID',
      'country_flag_unicode' => preg_replace_callback('/./', function ($matches) {
        return 'U+' . strtoupper(dechex(ord($matches[0]) + 127397));
      }, 'ID'),
      'country_name' => 'Indonesia',
      'status' => CountryStatus::ACTIVE
    ]);

    $provinceID = Province::factory()->create([
      'province_name' => 'Sumatera Utara',
      'status' => ProvinceStatus::ACTIVE,
      'country_id' => $countryID->id
    ]);

    $cityID = City::factory()->create([
      'city_name' => 'Medan',
      'status' => CityStatus::ACTIVE,
      'province_id' => $provinceID->id
    ]);

    $bank = Bank::factory()->create([
      'name' => 'Bank Danamon',
      'status' => BankStatus::ACTIVE,
      'country_id' => $countryID->id
    ]);

    $currency = Currency::factory()->create([
      'country_id' => $countryID->id,
      'currency_code' => 'IDR',
      'currency_name' => 'Rupiah',
      'currency_symbol_unicode' => '',
      'minor_unit' => '0',
      'transaction_fee' => '75000',
      'transaction_minimum_amount' => '500000',
      'transaction_maximum_amount' => '10000000'
    ]);

    $countrySG = Country::factory()->create([
      'country_code' => 'ID',
      'country_flag_unicode' => preg_replace_callback('/./', function ($matches) {
        return 'U+' . strtoupper(dechex(ord($matches[0]) + 127397));
      }, 'ID'),
      'country_name' => 'Indonesia',
      'status' => CountryStatus::ACTIVE
    ]);

    $provinceSG = Province::factory()->create([
      'province_name' => 'Central Region',
      'status' => ProvinceStatus::ACTIVE,
      'country_id' => $countrySG->id
    ]);

    $citySG = City::factory()->create([
      'city_name' => 'Central Area',
      'status' => CityStatus::ACTIVE,
      'province_id' => $provinceSG->id
    ]);

    $bankSG = Bank::factory()->create([
      'name' => 'OCBC',
      'status' => BankStatus::ACTIVE,
      'country_id' => $countrySG->id
    ]);

    $currencySG = Currency::factory()->create([
      'country_id' => $countrySG->id,
      'currency_code' => 'SGD',
      'currency_name' => 'Singapore Dollar',
      'currency_symbol_unicode' => 'U+0024',
      'minor_unit' => '2',
      'transaction_fee' => '2',
      'transaction_minimum_amount' => '100',
      'transaction_maximum_amount' => '10000'
    ]);

    $exchangeRatesIDRtoSGD = [0.000094, 0.000095, 0.000092, 0.000091];

    foreach ($exchangeRatesIDRtoSGD as $rate) {
      ExchangeRate::factory()->create([
        'currency_from' => 'IDR',
        'currency_to' => 'SGD',
        'conversion_rate' => $rate
      ]);
    }

    $exchangeRatesSGDtoIDR = [10557.17, 10600.17, 10400.52];

    foreach ($exchangeRatesSGDtoIDR as $rate) {
      ExchangeRate::factory()->create([
        'currency_from' => 'SGD',
        'currency_to' => 'IDR',
        'conversion_rate' => $rate
      ]);
    }
  }
}
