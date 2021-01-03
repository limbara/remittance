<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Voucher;
use App\Models\VoucherType;
use App\Models\VoucherValue;
use Faker\Factory;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $voucherType = VoucherType::create([
      'id' => 1,
      'description' => 'Discount Fee'
    ]);

    $vouchers = Voucher::factory()->count(5)->create([
      'voucher_type_id' => $voucherType->id
    ]);

    $currencies = Currency::all();

    $vouchers->each(function (Voucher $voucher) use ($currencies) {
      $currencies->each(function (Currency $currency) use ($voucher) {
        $faker = Factory::create();

        VoucherValue::create([
          'amount' => $faker->randomNumber(2),
          'currency_code' => $currency->currency_code,
          'voucher_id' => $voucher->id
        ]);
      });
    });
  }
}
