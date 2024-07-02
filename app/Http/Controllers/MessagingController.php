<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessagingRequest;
use App\Http\Requests\UpdateMessagingRequest;
use App\Models\Message;
use Illuminate\Http\JsonResponse;

class MessagingController extends BaseController
{

    public function index(): JsonResponse
    {
        $messages = Message::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($messages, 'Records retrieved successfully');
    }


    public function store(StoreMessagingRequest $request): JsonResponse
    {
        $data = $request->all();
        $message = Message::query()->create([
            'sender_id' => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'message' => $data['message'],
            'readStatus' => $data['readStatus']
        ]);
        return $this->buildSuccessResponse($message, 'Message sent successfully');
    }


    public function show($messagingId): JsonResponse
    {
        $messaging = Message::query()->firstWhere('id', '=', $messagingId);
        if ($messaging == null) {
            return $this->buildErrorResponse("Message with id " . $messagingId . " not found");
        }
        return $this->buildSuccessResponse($messaging, 'Message retrieved successfully');
    }


    public function update(UpdateMessagingRequest $request, $messagingId): JsonResponse
    {
        $message = Message::query()->firstWhere('id', '=', $messagingId);
        if ($message == null) {
            return $this->buildErrorResponse("Message with id " . $messagingId . " not found");
        }
        $data = $request->all();

        $message->update([
            'sender_id' => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'message' => $data['message'],
            'readStatus' => $data['readStatus']
        ]);

        return $this->buildSuccessResponse($message, 'Message updated successfully');
    }

    public function destroy($messagingId): JsonResponse
    {
        $message = Message::query()->firstWhere('id', '=', $messagingId);
        if ($message == null) {
            return $this->buildErrorResponse("Message with id " . $messagingId . " not found");
        }
        $message->delete();
        return $this->buildSuccessResponse(null, 'Message successfully deleted');
    }
}
