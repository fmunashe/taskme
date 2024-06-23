<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Traits\GlobalData;
use Illuminate\Http\JsonResponse;


class UsersController extends BaseController
{
    use GlobalData;

    public function index(): JsonResponse
    {
        $users = User::query()->with([
            'profile',
            'profile.experiences',
            'profile.experiences.duties',
            'profile.relatives',
            'profile.disabilities',
            'profile.healthConditions',
            'profile.references',
            'profile.documents'
        ])->latest()->paginate(10);
        return $this->buildSuccessResponse($users, "Records retrieved successfully");
    }


    public function show($userId): JsonResponse
    {
        $user = User::query()->with([
            'profile',
            'profile.experiences',
            'profile.experiences.duties',
            'profile.relatives',
            'profile.disabilities',
            'profile.healthConditions',
            'profile.references',
            'profile.documents'
        ])->firstWhere('id', '=', $userId);
        if ($user == null) {
            return $this->buildErrorResponse("User with id " . $userId . " not found");
        }
        return $this->buildSuccessResponse($user, "User record retrieved successfully");
    }


    public function update(UpdateUserRequest $updateUserRequest, User $user): JsonResponse
    {
        $data = $updateUserRequest->all();
        $user = $user->update([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'phoneNumber' => $data['phoneNumber'],
            'role_id' => $data['role_id'],
        ]);
        return $this->buildSuccessResponse($user, "User record successfully updated");
    }


    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return $this->buildSuccessResponse(null, "User record successfully deleted");
    }

}
