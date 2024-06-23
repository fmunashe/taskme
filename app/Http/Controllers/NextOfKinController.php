<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNextOfKinRequest;
use App\Http\Requests\UpdateNextOfKinRequest;
use App\Models\NextOfKin;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class NextOfKinController extends BaseController
{

    public function index(): JsonResponse
    {
        $relatives = NextOfKin::query()->with('profile')->latest()->paginate(10);
        return $this->buildSuccessResponse($relatives, 'Records successfully retrieved');
    }


    public function store(StoreNextOfKinRequest $request): JsonResponse
    {
        $data = $request->all();
        $user = User::query()->with('profile')->firstWhere('id', '=', $data['userId']);
        if (!$user) {
            return $this->buildErrorResponse('Provided user does not exist in our records');
        }
        $profile = $user->profile();
        $relative = NextOfKin::query()->create([
            'user_profile_id' => $profile->id,
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'relationship' => $data['relationship'],
            'address' => $data['address']
        ]);
        return $this->buildSuccessResponse($relative, 'Next of kin successfully attached to profile');
    }


    public function show($nextOfKinId): JsonResponse
    {
        $relative = NextOfKin::query()->firstWhere('id', '=', $nextOfKinId);
        if ($relative == null) {
            return $this->buildErrorResponse("Next of kin with id " . $nextOfKinId . " not found");
        }
        return $this->buildSuccessResponse($relative, 'Next of kin retrieved successfully');
    }


    public function update(UpdateNextOfKinRequest $request, $nextOfKinId): JsonResponse
    {
        $nextOfKin = NextOfKin::query()->firstWhere('id', '=', $nextOfKinId);
        if ($nextOfKin == null) {
            return $this->buildErrorResponse("Reference with id " . $nextOfKinId . " not found");
        }
        $data = $request->all();

        $nextOfKin->update([
            'user_profile_id' => $data['user_profile_id'],
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'relationship' => $data['relationship'],
            'address' => $data['address']
        ]);

        return $this->buildSuccessResponse($nextOfKin, 'Next of kin updated successfully');
    }


    public function destroy($nextOfKinId): JsonResponse
    {
        $nextOfKin = NextOfKin::query()->firstWhere('id', '=', $nextOfKinId);
        if ($nextOfKin == null) {
            return $this->buildErrorResponse("Next of kin with id " . $nextOfKinId . " not found");
        }
        $nextOfKin->delete();
        return $this->buildSuccessResponse(null, 'Next of kin successfully deleted');
    }
}
