<?php

namespace App\Providers;

use App\Events\Order\Created as OrderCreated;
use App\Events\Transaction\Approved;
use App\Events\Transaction\Expired;
use App\Events\Transaction\Rejected;
use App\Events\Transaction\Success;
use App\Listeners\Order\CreatedListener as OrderCreatedListener;
use App\Listeners\Transaction\ApprovedListener;
use App\Listeners\Transaction\ExpiredListener;
use App\Listeners\Transaction\RejectedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event listener mappings for the application.
   *
   * @var array
   */
  protected $listen = [
    OrderCreated::class => [
      OrderCreatedListener::class
    ],
    Approved::class => [
      ApprovedListener::class
    ],
    Expired::class => [
      ExpiredListener::class
    ],
    Rejected::class => [
      RejectedListener::class
    ],
    Success::class => [
      Success::class
    ],
  ];

  /**
   * Register any events for your application.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
