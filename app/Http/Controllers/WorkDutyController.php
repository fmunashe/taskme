<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkDutyRequest;
use App\Http\Requests\UpdateWorkDutyRequest;
use App\Models\WorkDuty;
use App\Models\WorkExperience;
use Illuminate\Http\JsonResponse;

class WorkDutyController extends BaseController
{

    public function index(): JsonResponse
    {
        $duties = WorkDuty::query()->with('experience')->latest()->paginate(10);
        return $this->buildSuccessResponse($duties, "Records retrieved successfully");
    }


    public function store(StoreWorkDutyRequest $request): JsonResponse
    {
        $data = $request->all();
        $experience = WorkExperience::query()->firstWhere('id', '=', $data['work_experience_id']);
        if (!$experience) {
            return $this->buildErrorResponse('Provided work experience does not exist in our records');
        }

        $duty = WorkDuty::query()->create([
            'work_experience_id' => $experience->id,
            'dutyDescription' => $data['dutyDescription']
        ]);
        return $this->buildSuccessResponse($duty, 'Experience duties successfully attached to work experience');
    }


    public function show($workDutyId): JsonResponse
    {
        $workDuty = WorkDuty::query()->firstWhere('id', '=', $workDutyId);
        if ($workDuty == null) {
            return $this->buildErrorResponse("Work duty with id " . $workDutyId . " not found");
        }
        return $this->buildSuccessResponse($workDuty, 'Work duty retrieved successfully');
    }


    public function update(UpdateWorkDutyRequest $request, $workDutyId): JsonResponse
    {

        $workDuty = WorkDuty::query()->firstWhere('id', '=', $workDutyId);
        if ($workDuty == null) {
            return $this->buildErrorResponse("Work duty with id " . $workDutyId . " not found");
        }
        $data = $request->all();

        $workDuty->update([
            'work_experience_id' => $data['work_experience_id'],
            'dutyDescription' => $data['dutyDescription']
        ]);

        return $this->buildSuccessResponse($workDuty, 'Work duty updated successfully');
    }


    public function destroy($workDutyId): JsonResponse
    {
        $workDuty = WorkDuty::query()->firstWhere('id', '=', $workDutyId);
        if ($workDuty == null) {
            return $this->buildErrorResponse("Work duty with id " . $workDutyId . " not found");
        }
        $workDuty->delete();
        return $this->buildSuccessResponse(null, 'Work duty successfully deleted');
    }
}
