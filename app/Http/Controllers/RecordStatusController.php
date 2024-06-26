<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecordStatusRequest;
use App\Http\Requests\UpdateRecordStatusRequest;
use App\Models\RecordStatus;
use Illuminate\Http\JsonResponse;

class RecordStatusController extends BaseController
{

    public function index(): JsonResponse
    {
        $statuses = RecordStatus::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($statuses, 'Records retrieved successfully');
    }


    public function store(StoreRecordStatusRequest $request): JsonResponse
    {
        $data = $request->all();

        $ref = RecordStatus::query()->create([
            'status' => $data['status'],
            'description' => $data['description']
        ]);
        return $this->buildSuccessResponse($ref, 'Record status created successfully');
    }


    public function show($recordStatusId)
    {
        $status = RecordStatus::query()->firstWhere('id', '=', $recordStatusId);
        if ($status == null) {
            return $this->buildErrorResponse("Record status with id " . $recordStatusId . " not found");
        }
        return $this->buildSuccessResponse($status, 'Record status retrieved successfully');
    }


    public function update(UpdateRecordStatusRequest $request, $recordStatusId): JsonResponse
    {
        $recordStatus = RecordStatus::query()->firstWhere('id', '=', $recordStatusId);
        if ($recordStatus == null) {
            return $this->buildErrorResponse("Record status with id " . $recordStatusId . " not found");
        }
        $data = $request->all();

        $recordStatus->update([
            'status' => $data['status'],
            'description' => $data['description']
        ]);

        return $this->buildSuccessResponse($recordStatus, 'Record status updated successfully');
    }


    public function destroy($recordStatusId): JsonResponse
    {
        $recordStatus = RecordStatus::query()->firstWhere('id', '=', $recordStatusId);
        if ($recordStatus == null) {
            return $this->buildErrorResponse("Record status with id " . $recordStatusId . " not found");
        }
        $recordStatus->delete();
        return $this->buildSuccessResponse(null, 'Record status successfully deleted');
    }
}
