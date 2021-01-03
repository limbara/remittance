<?php

namespace App\Services\Api;

use App\Exceptions\Api\ErrorException;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\Shared\ImageUploadService\ProfileImageUpload;
use Carbon\Carbon;

class ProfileService
{
  protected $profileImageUpload, $cityService;

  public function __construct(ProfileImageUpload $profileImageUpload, CityService $cityService)
  {
    $this->profileImageUpload = $profileImageUpload;

    $this->cityService = $cityService;
  }

  /**
   * create new User Profile
   * 
   * @param array $post data
   * @param User $user
   * @throws ErrorException|Exception
   * @return UserProfile
   */
  public function create(array $data, User $user): UserProfile
  {
    if ($user->userProfile) {
      throw new ErrorException('Profile already exist');
    }

    $city = $this->cityService->find($data['city_id']);

    if ($city->isInactive()) {
      throw new ErrorException('City is inactive');
    }

    $photo = $data['photo'] ?? null;
    $filename = null;

    try {
      if ($photo) {
        $filename = $this->profileImageUpload->upload($photo);
      }

      $userProfile = $user->userProfile()->create([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'birth_date' => Carbon::createFromDate($data['birth_date'])->format('Y-m-d'),
        'legal_identifier' => $data['legal_identifier'],
        'address' => $data['address'],
        'gender' => $data['gender'],
        'photo' => $filename,
        'verified' => false,
        'user_id' => $user->id,
        'city_id' => $city->id
      ]);
    } catch (\Exception $e) {
      if ($filename) {
        $this->profileImageUpload->delete($filename);
      }

      throw $e;
    }

    if ($userProfile->photo) {
      $userProfile->photo = $this->profileImageUpload->getImageWithPath($filename);
    }

    return $userProfile;
  }
}
