<?php

namespace App\Services\Api;

use App\Exceptions\Api\NotFoundException;
use App\Models\User;

class UserService
{
  /**
   * find User
   * 
   * @param int $userId
   * @return User $user;
   * @throws NotFoundException 
   */
  public function find(int $userId): User
  {
    $user = User::find($userId);

    if (!$user) {
      throw new NotFoundException('User Not Found');
    }

    return $user;
  }
  
  /**
   * create new User
   * 
   * @param array $post data
   * @return User
   */
  public function create(array $data): User
  {
    $user = User::create([
      'phone_number' => $data['phone_number'],
      'email' => $data['email']
    ]);

    return $user;
  }
}
