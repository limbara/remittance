<?php

namespace App\Listeners\Transaction;

use App\Events\Transaction\Success;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SuccessListener implements ShouldQueue
{
  use InteractsWithQueue;
  /**
   * Handle the event.
   *
   * @param  object  $event
   * @return void
   */
  public function handle(Success $event)
  {
    // fire notification

    return true;
  }
}
