<?php

namespace App\Services\Api;

use App\Enums\NotificationType;
use App\Events\Transaction\Created as TransactionCreated;
use App\Events\Transaction\Approved as TransactionApproved;
use App\Events\Transaction\Rejected as TransactionRejeced;
use App\Events\Transaction\Expired as TransactionExpired;
use App\Events\Transaction\Success as TransactionSuccess;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\User;

class NotificationService
{
  public static function notifyTransactionCreated(Transaction $transaction, User $user)
  {
    $notification = Notification::create([
      'title' => 'New Transaction Created',
      'body' => "New Transaction reference id {$transaction->id}",
      'user_id' => $user->id,
      'notification_type_id' => NotificationType::Order
    ]);

    TransactionCreated::dispatch($notification);
  }

  public static function notifyTransactionExpired(Transaction $transaction, User $user)
  {
    $notification = Notification::create([
      'title' => 'Transaction Expired',
      'body' => "Transaction reference id {$transaction->id}",
      'user_id' => $user->id,
      'notification_type_id' => NotificationType::Order
    ]);

    TransactionExpired::dispatch($notification);
  }

  public static function notifyTransactionSuccess(Transaction $transaction, User $user)
  {
    $notification = Notification::create([
      'title' => 'Transaction Success',
      'body' => "Transaction reference id {$transaction->id}",
      'user_id' => $user->id,
      'notification_type_id' => NotificationType::Order
    ]);

    TransactionSuccess::dispatch($notification);
  }

  public static function notifyTransactionApproved(Transaction $transaction, User $user)
  {
    $notification = Notification::create([
      'title' => 'Transaction Approved',
      'body' => "Transaction reference id {$transaction->id}",
      'user_id' => $user->id,
      'notification_type_id' => NotificationType::Order
    ]);

    TransactionApproved::dispatch($notification);
  }

  public static function notifyTransactionRejected(Transaction $transaction, User $user)
  {
    $notification = Notification::create([
      'title' => 'Transaction Rejected',
      'body' => "Transaction reference id {$transaction->id}",
      'user_id' => $user->id,
      'notification_type_id' => NotificationType::Order
    ]);

    TransactionRejeced::dispatch($notification);
  }
}
