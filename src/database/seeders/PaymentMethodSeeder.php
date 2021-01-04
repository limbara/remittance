<?php

namespace Database\Seeders;

use App\Enums\CountryHasPaymentMethodStatus;
use App\Enums\PaymentMethod as EnumsPaymentMethod;
use App\Models\Country;
use App\Models\CountryHasPaymentMethod;
use App\Models\PaymentMethod;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $paymentMethods = [
      [
        'id' => EnumsPaymentMethod::CREDIT_CARD,
        'name' => 'Kartu Kredit'
      ],
      [
        'id' => EnumsPaymentMethod::BANK_TRANSFER,
        'name' => 'Bank Transfer'
      ],
    ];

    $now = Carbon::now();

    PaymentMethod::insert(array_map(function ($paymentMethod) use ($now) {
      return array_merge($paymentMethod, [
        'created_at' => $now,
        'updated_at' => $now
      ]);
    }, $paymentMethods));

    $countries = Country::all();

    $countries->each(function (Country $country) use ($paymentMethods, $now) {

      CountryHasPaymentMethod::insert(array_map(function ($paymentMethod) use ($country, $now) {
        $faker = Factory::create();

        return [
          'status' => $faker->boolean(80) ? CountryHasPaymentMethodStatus::ACTIVE : CountryHasPaymentMethodStatus::INACTIVE,
          'payment_method_id' => $paymentMethod['id'],
          'country_id' => $country->id,
          'created_at' => $now,
          'updated_at' => $now
        ];
      }, $paymentMethods));
    });
  }
}
