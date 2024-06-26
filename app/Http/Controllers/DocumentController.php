<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class DocumentController extends BaseController
{

    public function index(): JsonResponse
    {
        $documents = Document::query()->with('userProfile')->latest()->paginate(10);
        return $this->buildSuccessResponse($documents, "Records retrieved successfully");
    }


    public function store(StoreDocumentRequest $request): JsonResponse
    {
        $data = $request->all();
        if (isset($data['document'])) {
            $fileName = time() . '_' . $data['document']->getClientOriginalName();
            $filePath = $data['document']->storeAs('uploads', $fileName, 'public');
            $data['name'] = $fileName;
            $data['documentPath'] = public_path($filePath);
            unset($data['document']);
        }

        $document = Document::query()->create($data);
        return $this->buildSuccessResponse($document, 'Document successfully attached to profile');
    }


    public function show($documentId): JsonResponse
    {
        $document = Document::query()->with(['userProfile'])->firstWhere('id', '=', $documentId);
        if ($document == null) {
            return $this->buildErrorResponse("Document with id " . $documentId . " not found");
        }
        return $this->buildSuccessResponse($document, 'Document retrieved successfully');

        //return Response()->file(storage_path() . '/app/public/uploads/' . $certification->certificateName);
    }


    public function update(UpdateDocumentRequest $request, $documentId): JsonResponse
    {
        $data = $request->all();
        $document = Document::query()->firstWhere('id', '=', $documentId);
        if ($document == null) {
            return $this->buildErrorResponse("Document with id " . $documentId . " not found");
        }

        if (isset($data['document'])) {
            if (!empty($document->name)) {
                $file_path = storage_path() . '/app/public/uploads/' . $document->name;
                if (File::exists($file_path)) {
                    unlink($file_path);
                }
            }
            $fileName = time() . '_' . $data['document']->getClientOriginalName();
            $filePath = $data['document']->storeAs('uploads', $fileName, 'public');
            $data['name'] = $fileName;
            $data['documentPath'] = public_path($filePath);
            unset($data['document']);
        }

        $document->update($data);

        return $this->buildSuccessResponse($document, 'Document updated successfully');
    }


    public function destroy($documentId): JsonResponse
    {
        $document = Document::query()->firstWhere('id', '=', $documentId);
        if ($document == null) {
            return $this->buildErrorResponse("Document with id " . $documentId . " not found");
        }
        $file_path = storage_path() . '/app/public/uploads/' . $document->name;
        if (File::exists($file_path)) {
            unlink($file_path);
        }
        $document->delete();
        return $this->buildSuccessResponse(null, 'Document successfully deleted');
    }
}
