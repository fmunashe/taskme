<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;

class UserProfileController extends BaseController
{

    public function index(): JsonResponse
    {
        $profiles = UserProfile::query()->with([
            'references',
            'experiences',
            'experiences.duties',
            'relatives',
            'disabilities',
            'healthConditions',
            'references',
            'documents'
        ])->latest()->paginate(10);
        return $this->buildSuccessResponse($profiles, 'Profiles retrieved successfully');
    }


    public function store(StoreUserProfileRequest $request): JsonResponse
    {
        $data = $request->all();
        $user = User::query()->firstWhere('id', '=', $data['userId']);
        if (!$user) {
            return $this->buildErrorResponse('Provided user does not exist in our records');
        }
        $profile = UserProfile::query()->create([
            'user_id' => $user->id,
            'dob' => $data['dob'],
            'idNumber' => $data['idNumber'],
            'profession' => $data['profession'],
            'highestEductionQualification' => $data['highestEductionQualification'],
            'bio' => $data['bio'],
            'maritalStatus' => $data['maritalStatus'],
            'gender' => $data['gender'],
            'religion' => $data['religion'],
            'address' => $data['address']
        ]);
        return $this->buildSuccessResponse($profile, 'User profile created successfully');
    }


    public function show($userProfileId): JsonResponse
    {
        $profile = UserProfile::query()->with([
            'references',
            'experiences',
            'experiences.duties',
            'relatives',
            'disabilities',
            'healthConditions',
            'references',
            'documents'
        ])->firstWhere('id', '=', $userProfileId);
        if ($profile == null) {
            return $this->buildErrorResponse("User profile with id " . $userProfileId . " not found");
        }
        return $this->buildSuccessResponse($profile, 'User profile retrieved successfully');
    }


    public function update(UpdateUserProfileRequest $request, $userProfileId): JsonResponse
    {
        $profile = UserProfile::query()->firstWhere('id', '=', $userProfileId);
        if ($profile == null) {
            return $this->buildErrorResponse("User profile with id " . $userProfileId . " not found");
        }
        $data = $request->all();

        $profile->update([
            'user_id' => $data['user_profile_id'],
            'dob' => $data['dob'],
            'idNumber' => $data['idNumber'],
            'profession' => $data['profession'],
            'highestEductionQualification' => $data['highestEductionQualification'],
            'bio' => $data['bio'],
            'maritalStatus' => $data['maritalStatus'],
            'gender' => $data['gender'],
            'religion' => $data['religion'],
            'address' => $data['address']
        ]);

        return $this->buildSuccessResponse($profile, 'User profile updated successfully');
    }


    public function destroy($userProfileId): JsonResponse
    {
        $profile = UserProfile::query()->firstWhere('id', '=', $userProfileId);
        if ($profile == null) {
            return $this->buildErrorResponse("User profile with id " . $userProfileId . " not found");
        }
        $profile->delete();
        return $this->buildSuccessResponse(null, 'User profile successfully deleted');
    }
}
