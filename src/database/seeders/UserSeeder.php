<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use App\Models\UserHasVoucher;
use App\Models\UserPointHistory;
use App\Models\UserProfile;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Faker\Factory;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $cityIds = City::all()->pluck('id')->all();

    $users = User::factory()->count(30)->has(
      UserPointHistory::factory()->count(5)
    )->has(
      UserProfile::factory()->state([
        'city_id' => Arr::random($cityIds)
      ])
    )->create();

    $voucherIds = Voucher::all()->pluck('id')->all();

    $users->each(function (User $user) use ($voucherIds) {
      $faker = Factory::create();

      if ($faker->boolean) {

        UserHasVoucher::create([
          'user_id' => $user->id,
          'voucher_id' => Arr::random($voucherIds),
        ]);
      }
    });
  }
}
