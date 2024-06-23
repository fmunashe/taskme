<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHealthConditionRequest;
use App\Http\Requests\UpdateHealthConditionRequest;
use App\Models\HealthCondition;
use App\Models\NextOfKin;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class HealthConditionController extends BaseController
{

    public function index(): JsonResponse
    {
        $conditions = HealthCondition::query()->with('profile')->latest()->paginate(10);
        return $this->buildSuccessResponse($conditions, 'Records retrieved successfully');
    }


    public function store(StoreHealthConditionRequest $request): JsonResponse
    {
        $data = $request->all();
        $user = User::query()->with('profile')->firstWhere('id', '=', $data['userId']);
        if (!$user) {
            return $this->buildErrorResponse('Provided user does not exist in our records');
        }
        $profile = $user->profile();
        $condition = HealthCondition::query()->create([
            'user_profile_id' => $profile->id,
            'conditionName' => $data['conditionName'],
            'description' => $data['description']
        ]);
        return $this->buildSuccessResponse($condition, 'Health condition successfully attached to profile');
    }


    public function show($healthConditionId): JsonResponse
    {
        $condition = NextOfKin::query()->firstWhere('id', '=', $healthConditionId);
        if ($condition == null) {
            return $this->buildErrorResponse("Health condition with id " . $healthConditionId . " not found");
        }
        return $this->buildSuccessResponse($condition, 'Health conditionø retrieved successfully');
    }


    public function update(UpdateHealthConditionRequest $request, $healthConditionId): JsonResponse
    {
        $healthCondition = NextOfKin::query()->firstWhere('id', '=', $healthConditionId);
        if ($healthCondition == null) {
            return $this->buildErrorResponse("Health condition with id " . $healthConditionId . " not found");
        }
        $data = $request->all();

        $healthCondition->update([
            'user_profile_id' => $data['user_profile_id'],
            'conditionName' => $data['conditionName'],
            'description' => $data['description']
        ]);

        return $this->buildSuccessResponse($healthCondition, 'Health condition updated successfully');
    }

    public function destroy($healthConditionId): JsonResponse
    {
        $healthCondition = NextOfKin::query()->firstWhere('id', '=', $healthConditionId);
        if ($healthCondition == null) {
            return $this->buildErrorResponse("Health condition with id " . $healthConditionId . " not found");
        }
        $healthCondition->delete();
        return $this->buildSuccessResponse(null, 'Health condition successfully deleted');
    }
}
