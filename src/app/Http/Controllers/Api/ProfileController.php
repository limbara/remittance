<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Profile\CreateRequest;
use App\Services\Api\ProfileService;
use App\Services\Api\UserService;

class ProfileController extends Controller
{
  protected $profileService, $userService;

  public function __construct(ProfileService $profileService, UserService $userService)
  {
    $this->profileService = $profileService;
    $this->userService = $userService;
  }

  public function create(CreateRequest $createRequest)
  {
    $user = $this->userService->find($createRequest->input('user_id'));

    $userProfile = $this->profileService->create($createRequest->validated(), $user);

    return response()->json([
      'user_profile' => $userProfile
    ]);
  }
}
