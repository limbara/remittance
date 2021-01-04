<?php

namespace App\Services\Api;

use App\Enums\PointHistoryType;
use App\Exceptions\Api\ErrorException;
use App\Models\User;
use App\Models\UserPointHistory;
use Carbon\Carbon;

class UserPointService
{
  /**
   * @var User;
   */
  protected $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function isPointAvailable(): bool
  {
    return $this->user->point > 0;
  }

  public function getPoint(): int
  {
    return $this->user->point;
  }

  public function createTransaction(string $description, int $type, int $amount, Carbon $createdAt): UserPointHistory
  {
    switch ($type) {
      case PointHistoryType::IN:
        return $this->createTransactionPointIn($description, $amount, $createdAt);
      case PointHistoryType::OUT:
        return $this->createTransactionPointOut($description, $amount, $createdAt);
      default:
        throw new ErrorException('Point Type not valid');
    }
  }

  private function createTransactionPointIn(string $description, int $amount, Carbon $createdAt): UserPointHistory
  {
    try {
      $this->user->increment('point', $amount);

      $userPointHistory = UserPointHistory::create([
        'description' => $description,
        'type' => PointHistoryType::IN,
        'amount' => $amount,
        'created_at' => $createdAt->format('Y-m-d H:i:s'),
        'user_id' => $this->user->id
      ]);

      return $userPointHistory;
    } catch (\Exception $e) {

      throw $e;
    }
  }

  private function createTransactionPointOut(string $description, int $amount, Carbon $createdAt): UserPointHistory
  {
    if (!$this->isPointAvailable()) {
      throw new ErrorException("Point not sufficient");
    }

    try {
      $this->user->decrement('point', $amount);

      $userPointHistory = UserPointHistory::create([
        'description' => $description,
        'type' => PointHistoryType::OUT,
        'amount' => $amount,
        'created_at' => $createdAt->format('Y-m-d H:i:s'),
        'user_id' => $this->user->id
      ]);

      return $userPointHistory;
    } catch (\Exception $e) {

      throw $e;
    }
  }
}
