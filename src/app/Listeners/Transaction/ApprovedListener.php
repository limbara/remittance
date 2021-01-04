<?php

namespace App\Listeners\Transaction;

use App\Events\Transaction\Approved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ApprovedListener implements ShouldQueue
{
  use InteractsWithQueue;
  /**
   * Handle the event.
   *
   * @param  object  $event
   * @return void
   */
  public function handle(Approved $event)
  {
    // fire notification

    return true;
  }
}
