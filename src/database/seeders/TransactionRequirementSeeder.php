<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\CountryHasTransactionRequirement;
use App\Models\TransactionRequirement;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TransactionRequirementSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $countries = Country::all();

    $transactionRequirements = [
      [
        'key' =>  'RECIPIENT_ADDRESS',
        'description' => 'Recipient Address'
      ],
      [
        'key' => 'RECIPIENT_POSTAL_CODE',
        'description' => 'Recipient Postal Code'
      ],
      [
        'key' => 'RECIPIENT_CITY_ID',
        'description' => 'Recipient City Id'
      ]
    ];

    $now = Carbon::now();

    TransactionRequirement::insert(array_map(function ($transactionRequirement) use ($now) {
      return array_merge($transactionRequirement, [
        'created_at' => $now,
        'updated_at' => $now
      ]);
    }, $transactionRequirements));

    $countries->each(function (Country $country) use ($transactionRequirements) {
      $faker = Factory::create();

      if ($faker->boolean(30)) {
        $now = Carbon::now();

        CountryHasTransactionRequirement::insert(array_map(function ($transactionRequirement) use ($country, $now) {
          return [
            'transaction_requirement_key' => $transactionRequirement['key'],
            'country_id' => $country->id,
            'created_at' => $now,
            'updated_at' => $now,
          ];
        }, $transactionRequirements));
      }
    });
  }
}
