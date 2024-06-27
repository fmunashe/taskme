<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobListingRequest;
use App\Http\Requests\UpdateJobListingRequest;
use App\Models\JobListing;
use Illuminate\Http\JsonResponse;

class JobListingController extends BaseController
{

    public function index(): JsonResponse
    {
        $listings = JobListing::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($listings, 'Records retrieved successfully');
    }


    public function store(StoreJobListingRequest $request): JsonResponse
    {
        $data = $request->all();
        $relative = JobListing::query()->create([
            'record_status_id' => $data['record_status_id'],
            'job_category_id' => $data['job_category_id'],
            'user_id' => $data['user_id'],
            'jobTitle' => $data['jobTitle'],
            'jobDescription' => $data['jobDescription']
        ]);
        return $this->buildSuccessResponse($relative, 'Job listing successfully created');
    }


    public function show($jobListingId): JsonResponse
    {
        $listing = JobListing::query()->firstWhere('id', '=', $jobListingId);
        if ($listing == null) {
            return $this->buildErrorResponse("Job listing with id " . $jobListingId . " not found");
        }
        return $this->buildSuccessResponse($listing, 'Job listing retrieved successfully');
    }


    public function update(UpdateJobListingRequest $request, $jobListingId): JsonResponse
    {
        $jobListing = JobListing::query()->firstWhere('id', '=', $jobListingId);
        if ($jobListing == null) {
            return $this->buildErrorResponse("Job listing with id " . $jobListingId . " not found");
        }
        $data = $request->all();

        $jobListing->update([
            'record_status_id' => $data['record_status_id'],
            'job_category_id' => $data['job_category_id'],
            'user_id' => $data['user_id'],
            'jobTitle' => $data['jobTitle'],
            'jobDescription' => $data['jobDescription']
        ]);

        return $this->buildSuccessResponse($jobListing, 'Job category updated successfully');
    }


    public function destroy($jobListingId): JsonResponse
    {
        $jobListing = JobListing::query()->firstWhere('id', '=', $jobListingId);
        if ($jobListing == null) {
            return $this->buildErrorResponse("Job listing with id " . $jobListingId . " not found");
        }
        $jobListing->delete();
        return $this->buildSuccessResponse(null, 'Job listing successfully deleted');
    }
}
