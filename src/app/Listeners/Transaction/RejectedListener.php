<?php

namespace App\Listeners\Transaction;

use App\Events\Transaction\Created;
use App\Events\Transaction\Rejected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RejectedListener implements ShouldQueue
{
  use InteractsWithQueue;
  /**
   * Handle the event.
   *
   * @param  object  $event
   * @return void
   */
  public function handle(Rejected $event)
  {
    // fire notification

    return true;
  }
}
