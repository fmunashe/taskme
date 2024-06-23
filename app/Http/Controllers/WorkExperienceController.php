<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkExperienceRequest;
use App\Http\Requests\UpdateWorkExperienceRequest;
use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Http\JsonResponse;


class WorkExperienceController extends BaseController
{

    public function index(): JsonResponse
    {
        $experience = WorkExperience::query()->with(['profile', 'duties'])->latest()->paginate(10);
        return $this->buildSuccessResponse($experience, "Records retrieved successfully");
    }


    public function store(StoreWorkExperienceRequest $request): JsonResponse
    {
        $data = $request->all();
        $user = User::query()->with('profile')->firstWhere('id', '=', $data['userId']);
        if (!$user) {
            return $this->buildErrorResponse('Provided user does not exist in our records');
        }
        $profile = $user->profile();
        $ref = WorkExperience::query()->create([
            'user_profile_id' => $profile->id,
            'positionHeld' => $data['positionHeld'],
            'startDate' => $data['startDate'],
            'endDate' => $data['endDate'],
            'reasonForLeaving' => $data['reasonForLeaving'],
            'organisation' => $data['organisation']
        ]);
        return $this->buildSuccessResponse($ref, 'Work experience successfully attached to profile');
    }


    public function show($workExperienceId): JsonResponse
    {
        $workExperience = WorkExperience::query()->firstWhere('id', '=', $workExperienceId);
        if ($workExperience == null) {
            return $this->buildErrorResponse("Work experience with id " . $workExperienceId . " not found");
        }
        return $this->buildSuccessResponse($workExperience, 'Work experience retrieved successfully');
    }


    public function update(UpdateWorkExperienceRequest $request, $workExperienceId): JsonResponse
    {
        $workExperience = WorkExperience::query()->firstWhere('id', '=', $workExperienceId);
        if ($workExperience == null) {
            return $this->buildErrorResponse("Work experience with id " . $workExperienceId . " not found");
        }
        $data = $request->all();

        $workExperience->update([
            'user_profile_id' => $data['user_profile_id'],
            'positionHeld' => $data['positionHeld'],
            'startDate' => $data['startDate'],
            'endDate' => $data['endDate'],
            'reasonForLeaving' => $data['reasonForLeaving'],
            'organisation' => $data['organisation']
        ]);

        return $this->buildSuccessResponse($workExperience, 'Work experience updated successfully');
    }


    public function destroy($workExperienceId): JsonResponse
    {
        $workExperience = WorkExperience::query()->firstWhere('id', '=', $workExperienceId);
        if ($workExperience == null) {
            return $this->buildErrorResponse("Work experience with id " . $workExperienceId . " not found");
        }
        $workExperience->delete();
        return $this->buildSuccessResponse(null, 'Work experience successfully deleted');
    }
}
