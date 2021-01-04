<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\CreateRequest;
use App\Services\Api\UserService;

class UserController extends Controller
{
  protected $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function create(CreateRequest $createRequest)
  {
    $user = $this->userService->create($createRequest->validated());

    return response()->json([
      'user' => $user
    ]);
  }
}
