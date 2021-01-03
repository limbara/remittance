<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Recipient;
use App\Models\Relationship;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class RelationshipSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $relationships = [
      [
        'id' => 1,
        'description' => 'Family'
      ],
      [
        'id' => 2,
        'description' => 'Business Partner'
      ],
      [
        'id' => 3,
        'description' => 'Friends'
      ],
      [
        'id' => 4,
        'description' => 'Others'
      ]
    ];

    $now = Carbon::now();

    Relationship::insert(array_map(function ($relationship) use ($now) {
      return array_merge($relationship, [
        'created_at' => $now,
        'updated_at' => $now
      ]);
    }, $relationships));

    $users = User::all();
    $bankIds = Bank::all()->pluck('id')->all();

    $users->each(function (User $user) use ($relationships, $bankIds) {
      $randomRelationship = Arr::random($relationships);
      $randomBankId = Arr::random($bankIds);

      Recipient::factory()->count(10)->create([
        'relationship_id' => $randomRelationship['id'],
        'user_id' => $user->id,
        'bank_id' => $randomBankId
      ]);
    });
  }
}
