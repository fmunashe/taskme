<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventTypeRequest;
use App\Http\Requests\UpdateEventTypeRequest;
use App\Models\EventType;
use App\Models\RecordStatus;
use Illuminate\Http\JsonResponse;

class EventTypeController extends BaseController
{

    public function index(): JsonResponse
    {
        $types = EventType::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($types, "Records retrieved successfully");
    }

    public function store(StoreEventTypeRequest $request): JsonResponse
    {
        $data = $request->all();
        $recordStatus = RecordStatus::query()->firstWhere('status', '=', "Active");
        $eventType = EventType::query()->create([
            'record_status_id' => $recordStatus->id,
            'eventType' => $data['eventType'],
            'eventDescription' => $data['eventDescription']
        ]);
        return $this->buildSuccessResponse($eventType, 'Event Type created successfully');
    }

    public function show(EventType $eventType): JsonResponse
    {
        return $this->buildSuccessResponse($eventType, 'Record retrieved successfully');
    }


    public function update(UpdateEventTypeRequest $request, EventType $eventType): JsonResponse
    {
        $record = $eventType->update([
            'record_status_id' => $request->record_status_id,
            'eventType' => $request->eventType,
            'eventDescription' => $request->eventDescription,
        ]);
        return $this->buildSuccessResponse($record, 'Event type updated successfully');
    }


    public function destroy(EventType $eventType): JsonResponse
    {
        $eventType->delete();
        return $this->buildSuccessResponse(null, 'Event type deleted successfully');
    }
}
