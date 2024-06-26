<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceCategoryRequest;
use App\Http\Requests\UpdateServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\JsonResponse;

class ServiceCategoryController extends BaseController
{

    public function index(): JsonResponse
    {
        $categories = ServiceCategory::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($categories, "Records Retrieved Successfully");
    }

    public function store(StoreServiceCategoryRequest $request): JsonResponse
    {
        $data = $request->all();
        $serviceCategory = ServiceCategory::query()->create([
            'categoryName' => $data['categoryName'],
            'categoryDescription' => $data['categoryDescription'],
        ]);
        return $this->buildSuccessResponse($serviceCategory, "Service category created successfully");
    }


    public function show($serviceCategoryId): JsonResponse
    {
        $category = ServiceCategory::query()->firstWhere('id', '=', $serviceCategoryId);
        if ($category == null) {
            return $this->buildErrorResponse("Service category with id " . $serviceCategoryId . " not found");
        }
        return $this->buildSuccessResponse($category, 'Service category retrieved successfully');
    }


    public function update(UpdateServiceCategoryRequest $request, $serviceCategoryId): JsonResponse
    {
        $category = ServiceCategory::query()->firstWhere('id', '=', $serviceCategoryId);
        if ($category == null) {
            return $this->buildErrorResponse("Service category with id " . $serviceCategoryId . " not found");
        }
        $data = $request->all();

        $category->update([
            'categoryName' => $data['categoryName'],
            'categoryDescription' => $data['categoryDescription']
        ]);

        return $this->buildSuccessResponse($category, 'Service category updated successfully');
    }


    public function destroy($serviceCategoryId): JsonResponse
    {
        $category = ServiceCategory::query()->firstWhere('id', '=', $serviceCategoryId);
        if ($category == null) {
            return $this->buildErrorResponse("Service category with id " . $serviceCategoryId . " not found");
        }
        $category->delete();
        return $this->buildSuccessResponse(null, 'User profile successfully deleted');
    }
}
