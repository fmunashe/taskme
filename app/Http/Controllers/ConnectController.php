<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConnectRequest;
use App\Http\Requests\UpdateConnectRequest;
use App\Models\Connect;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ConnectController extends BaseController
{

    public function index(): JsonResponse
    {
        $connects = Connect::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($connects, 'Records retrieved successfully');
    }


    public function store(StoreConnectRequest $request): JsonResponse
    {
        $connects = $request->totalConnects;
        $userId = $request->userId;
        $user = User::query()->firstWhere('id', '=', $userId);
        if (!$user) {
            return $this->buildErrorResponse('Provided user id does not exist');
        }

        $profile = $user->profile;
        if (!$profile) {
            return $this->buildErrorResponse('Provided user has no profile');
        }

        $connect = Connect::query()->create([
            'user_profile_id' => $profile->id,
            'totalConnects' => $connects
        ]);

        return $this->buildSuccessResponse($connect, 'Record successfully created');
    }


    public function show(Connect $connect): JsonResponse
    {
        return $this->buildSuccessResponse($connect, 'Record successfully retrieved');
    }

    public function update(UpdateConnectRequest $request, Connect $connect): JsonResponse
    {
        $connect->update([
            'user_profile_id' => $request->user_profile_id,
            'totalConnects' => $request->totalConnects,
        ]);
        return $this->buildSuccessResponse(null, 'Record successfully updated');
    }

    public function destroy(Connect $connect): JsonResponse
    {
        $connect->delete();
        return $this->buildSuccessResponse(null, 'Record successfully deleted');
    }
}
