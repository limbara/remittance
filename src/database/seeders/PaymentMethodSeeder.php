<?php

namespace Database\Seeders;

use App\Enums\CountryHasPaymentMethodStatus;
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
        'id' => 1,
        'name' => 'Kartu Kredit'
      ],
      [
        'id' => 2,
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

    $countries->each(function (Country $country) use ($paymentMethods) {

      CountryHasPaymentMethod::insert(array_map(function ($paymentMethod) use ($country) {
        $faker = Factory::create();

        return [
          'status' => $faker->boolean(80) ? CountryHasPaymentMethodStatus::ACTIVE : CountryHasPaymentMethodStatus::INACTIVE,
          'payment_method_id' => $paymentMethod['id'],
          'country_id' => $country->id
        ];
      }, $paymentMethods));
    });
  }
}
