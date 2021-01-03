<?php

namespace App\Services\Api;

use App\Exceptions\Api\NotFoundException;
use App\Models\Recipient;
use App\Models\User;

class RecipientService
{
  /**
   * find Recipient
   * 
   * @param User $user
   * @param int $recipientId
   * @return Recipient $recipient;
   * @throws NotFoundException 
   */
  public function findUserRecipient(User $user, int $recipientId): Recipient
  {
    $recipient = $user->recipients()->where('id', $recipientId)->first();

    if (!$recipient) {
      throw new NotFoundException('Recipient Not Found');
    }

    return $recipient;
  }
}
