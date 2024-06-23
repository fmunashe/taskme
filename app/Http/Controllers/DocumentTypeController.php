<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentTypeRequest;
use App\Http\Requests\UpdateDocumentTypeRequest;
use App\Models\DocumentType;
use App\Models\Reference;
use Illuminate\Http\JsonResponse;

class DocumentTypeController extends BaseController
{

    public function index(): JsonResponse
    {
        $documentTypes = DocumentType::query()->latest()->paginate(10);
        return $this->buildSuccessResponse($documentTypes, "Records retrieved successfully");
    }


    public function store(StoreDocumentTypeRequest $request): JsonResponse
    {
        $data = $request->all();

        $documentType = DocumentType::query()->create([
            'documentType' => $data['documentType'],
            'description' => $data['description'],
            'status' => $data['status']
        ]);
        return $this->buildSuccessResponse($documentType, 'Document type successfully created');

    }


    public function show($documentTypeId): JsonResponse
    {
        $documentType = Reference::query()->firstWhere('id', '=', $documentTypeId);
        if ($documentType == null) {
            return $this->buildErrorResponse("Document type with id " . $documentTypeId . " not found");
        }
        return $this->buildSuccessResponse($documentType, 'Document type retrieved successfully');
    }


    public function update(UpdateDocumentTypeRequest $request, $documentTypeId): JsonResponse
    {
        $documentType = DocumentType::query()->firstWhere('id', '=', $documentTypeId);
        if ($documentType == null) {
            return $this->buildErrorResponse("Document type with id " . $documentTypeId . " not found");
        }
        $data = $request->all();

        $documentType->update([
            'documentType' => $data['documentType'],
            'description' => $data['description'],
            'status' => $data['status']
        ]);

        return $this->buildSuccessResponse($documentType, 'Document type updated successfully');
    }


    public function destroy($documentTypeId): JsonResponse
    {
        $documentType = DocumentType::query()->firstWhere('id', '=', $documentTypeId);
        if ($documentType == null) {
            return $this->buildErrorResponse("Document type with id " . $documentTypeId . " not found");
        }
        $documentType->delete();
        return $this->buildSuccessResponse(null, 'Document type successfully deleted');
    }
}
