<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReferenceRequest;
use App\Http\Requests\UpdateReferenceRequest;
use App\Models\Reference;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ReferenceController extends BaseController
{
    public function index(): JsonResponse
    {
        $references = Reference::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($references, 'References retrieved successfully');
    }


    public function store(StoreReferenceRequest $request): JsonResponse
    {
        $data = $request->all();
        $user = User::query()->with('profile')->firstWhere('id', '=', $data['userId']);
        if (!$user) {
            return $this->buildErrorResponse('Provided user does not exist in our records');
        }
        $profile = $user->profile();
        $ref = Reference::query()->create([
            'user_profile_id' => $profile->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'role' => $data['role'],
            'organisation' => $data['organisation']
        ]);
        return $this->buildSuccessResponse($ref, 'Reference added successfully');
    }


    public function show($referenceId): JsonResponse
    {
        $reference = Reference::query()->firstWhere('id', '=', $referenceId);
        if ($reference == null) {
            return $this->buildErrorResponse("Reference with id " . $referenceId . " not found");
        }
        return $this->buildSuccessResponse($reference, 'Reference retrieved successfully');
    }


    public function update(UpdateReferenceRequest $request, $referenceId): JsonResponse
    {
        $reference = Reference::query()->firstWhere('id', '=', $referenceId);
        if ($reference == null) {
            return $this->buildErrorResponse("Reference with id " . $referenceId . " not found");
        }
        $data = $request->all();

        $reference->update([
            'user_profile_id' => $data['user_profile_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'role' => $data['role'],
            'organisation' => $data['organisation']
        ]);

        return $this->buildSuccessResponse($reference, 'Reference updated successfully');
    }


    public function destroy($referenceId): JsonResponse
    {
        $reference = Reference::query()->firstWhere('id', '=', $referenceId);
        if ($reference == null) {
            return $this->buildErrorResponse("Reference with id " . $referenceId . " not found");
        }
        $reference->delete();
        return $this->buildSuccessResponse(null, 'Reference successfully deleted');
    }
}
