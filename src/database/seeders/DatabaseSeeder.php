<?php

namespace Database\Seeders;

use App\Enums\PaymentMethod;
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
  }
}
