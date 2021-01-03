<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\NotificationType;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $users = User::all();

    $notificationType = NotificationType::create([
      'id' => 1,
      'name' => 'Order Notification'
    ]);

    $users->each(function (User $user) use ($notificationType) {
      Notification::factory(10)->create([
        'user_id' => $user,
        'notification_type_id' => $notificationType->id
      ]);
    });
  }
}
