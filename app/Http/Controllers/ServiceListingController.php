<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceListingRequest;
use App\Http\Requests\UpdateServiceListingRequest;
use App\Models\ServiceListing;
use Illuminate\Http\JsonResponse;

class ServiceListingController extends BaseController
{

    public function index(): JsonResponse
    {
        $listings = ServiceListing::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($listings, "Records Retrieved Successfully");
    }


    public function store(StoreServiceListingRequest $request): JsonResponse
    {
        $data = $request->all();
        $serviceCategory = ServiceListing::query()->create([
            'service_category_id' => $data['service_category_id'],
            'user_id' => $data['user_id'],
            'record_status_id' => $data['record_status_id'],
            'serviceName' => $data['serviceName'],
            'serviceDescription' => $data['serviceDescription']
        ]);
        return $this->buildSuccessResponse($serviceCategory, "Service listing created successfully");
    }


    public function show($serviceListingId): JsonResponse
    {
        $serviceListing = ServiceListing::query()->firstWhere('id', '=', $serviceListingId);
        if ($serviceListing == null) {
            return $this->buildErrorResponse("Service listing with id " . $serviceListingId . " not found");
        }
        return $this->buildSuccessResponse($serviceListing, 'Service listing retrieved successfully');
    }


    public function update(UpdateServiceListingRequest $request, $serviceListingId): JsonResponse
    {
        $serviceListing = ServiceListing::query()->firstWhere('id', '=', $serviceListingId);
        if ($serviceListing == null) {
            return $this->buildErrorResponse("Service listing with id " . $serviceListing . " not found");
        }
        $data = $request->all();

        $serviceListing->update([
            'service_category_id' => $data['service_category_id'],
            'user_id' => $data['user_id'],
            'record_status_id' => $data['record_status_id'],
            'serviceName' => $data['serviceName'],
            'serviceDescription' => $data['serviceDescription']
        ]);

        return $this->buildSuccessResponse($serviceListing, 'Service listing updated successfully');
    }


    public function destroy($serviceListingId): JsonResponse
    {
        $listing = ServiceListing::query()->firstWhere('id', '=', $serviceListingId);
        if ($listing == null) {
            return $this->buildErrorResponse("Service listing with id " . $serviceListingId . " not found");
        }
        $listing->delete();
        return $this->buildSuccessResponse(null, 'Service listing successfully deleted');
    }
}
