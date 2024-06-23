<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDisabilityRequest;
use App\Http\Requests\UpdateDisabilityRequest;
use App\Models\Disability;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DisabilityController extends BaseController
{

    public function index(): JsonResponse
    {
        $disabilities = Disability::query()->with('profile')->latest()->paginate(10);
        return $this->buildSuccessResponse($disabilities, "Records retrieved successfully");
    }


    public function store(StoreDisabilityRequest $request): JsonResponse
    {
        $data = $request->all();
        $user = User::query()->with('profile')->firstWhere('id', '=', $data['userId']);
        if (!$user) {
            return $this->buildErrorResponse('Provided user does not exist in our records');
        }
        $profile = $user->profile();
        $ref = Disability::query()->create([
            'user_profile_id' => $profile->id,
            'name' => $data['name'],
            'description' => $data['description']
        ]);
        return $this->buildSuccessResponse($ref, 'Disability successfully attached to profile');
    }


    public function show($disabilityId): JsonResponse
    {
        $disability = Disability::query()->firstWhere('id', '=', $disabilityId);
        if ($disability == null) {
            return $this->buildErrorResponse("Disability with id " . $disabilityId . " not found");
        }
        return $this->buildSuccessResponse($disability, 'Disability retrieved successfully');
    }


    public function update(UpdateDisabilityRequest $request, $disabilityId): JsonResponse
    {
        $disability = Disability::query()->firstWhere('id', '=', $disabilityId);
        if ($disability == null) {
            return $this->buildErrorResponse("Disability with id " . $disabilityId . " not found");
        }
        $data = $request->all();

        $disability->update([
            'user_profile_id' => $data['user_profile_id'],
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        return $this->buildSuccessResponse($disability, 'Disability updated successfully');
    }


    public function destroy($disabilityId): JsonResponse
    {
        $disability = Disability::query()->firstWhere('id', '=', $disabilityId);
        if ($disability == null) {
            return $this->buildErrorResponse("Disability with id " . $disabilityId . " not found");
        }
        $disability->delete();
        return $this->buildSuccessResponse(null, 'Disability successfully deleted');
    }
}
