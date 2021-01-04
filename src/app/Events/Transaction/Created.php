<?php

namespace App\Events\Transaction;

use App\Models\Notification;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Created
{
  use SerializesModels, Dispatchable;

  /**
   * @var Notification
   */
  public $notification;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(Notification $notification)
  {
    $this->notification = $notification;
  }
}
