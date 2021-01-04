<?php

namespace App\Listeners\Transaction;

use App\Events\Transaction\Created;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreatedListener implements ShouldQueue
{
  use InteractsWithQueue;
  /**
   * Handle the event.
   *
   * @param  object  $event
   * @return void
   */
  public function handle(Created $event)
  {
    // fire notification

    return true;
  }
}
