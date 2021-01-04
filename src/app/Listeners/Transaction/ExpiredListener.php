<?php

namespace App\Listeners\Transaction;

use App\Events\Transaction\Expired;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ExpiredListener implements ShouldQueue
{
  use InteractsWithQueue;
  /**
   * Handle the event.
   *
   * @param  object  $event
   * @return void
   */
  public function handle(Expired $event)
  {
    // fire notification

    return true;
  }
}
