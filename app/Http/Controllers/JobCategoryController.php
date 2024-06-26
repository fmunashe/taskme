<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobCategoryRequest;
use App\Http\Requests\UpdateJobCategoryRequest;
use App\Models\JobCategory;
use Illuminate\Http\JsonResponse;

class JobCategoryController extends BaseController
{

    public function index(): JsonResponse
    {
        $categories = JobCategory::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($categories, 'Records successfully retrieved');
    }


    public function store(StoreJobCategoryRequest $request): JsonResponse
    {
        $data = $request->all();
        $relative = JobCategory::query()->create([
            'record_status_id' => $data['record_status_id'],
            'categoryName' => $data['categoryName'],
            'categoryDescription' => $data['categoryDescription']
        ]);
        return $this->buildSuccessResponse($relative, 'Job category successfully created');
    }


    public function show($jobCategoryId): JsonResponse
    {
        $category = JobCategory::query()->firstWhere('id', '=', $jobCategoryId);
        if ($category == null) {
            return $this->buildErrorResponse("Job category with id " . $jobCategoryId . " not found");
        }
        return $this->buildSuccessResponse($category, 'Job category retrieved successfully');
    }

    public function update(UpdateJobCategoryRequest $request, $jobCategoryId): JsonResponse
    {
        $jobCategory = JobCategory::query()->firstWhere('id', '=', $jobCategoryId);
        if ($jobCategory == null) {
            return $this->buildErrorResponse("Job category with id " . $jobCategoryId . " not found");
        }
        $data = $request->all();

        $jobCategory->update([
            'record_status_id' => $data['record_status_id'],
            'categoryName' => $data['categoryName'],
            'categoryDescription' => $data['categoryDescription']
        ]);

        return $this->buildSuccessResponse($jobCategory, 'Job category updated successfully');
    }


    public function destroy($jobCategoryId): JsonResponse
    {
        $jobCategory = JobCategory::query()->firstWhere('id', '=', $jobCategoryId);
        if ($jobCategory == null) {
            return $this->buildErrorResponse("Job category with id " . $jobCategoryId . " not found");
        }
        $jobCategory->delete();
        return $this->buildSuccessResponse(null, 'Job category successfully deleted');
    }
}
