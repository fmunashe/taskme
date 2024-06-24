<?php

namespace App\Http\Controllers;

use App\Enums\DocumentTypeEnum;
use App\Http\Requests\DocumentVerificationRequest;
use App\Models\Document;
use Illuminate\Http\JsonResponse;

class DocumentsVerificationController extends BaseController
{
    public function verifyCV(DocumentVerificationRequest $request): JsonResponse
    {
        $document = Document::query()->firstWhere('id', '=', $request->documentId);
        if (!$document) {
            return $this->buildErrorResponse("Document with id " . $request->documentId . " not found");
        }

        if ($document->docType->documentType == DocumentTypeEnum::CV) {
            $document->update([
                'verified' => true
            ]);
            return $this->buildSuccessResponse($document, 'CV successfully verified');
        }
        return $this->buildErrorResponse("The provided document is not a CV and cannot be verified ");
    }

    public function verifyPoliceClearance(DocumentVerificationRequest $request): JsonResponse
    {
        $document = Document::query()->firstWhere('id', '=', $request->documentId);
        if (!$document) {
            return $this->buildErrorResponse("Document with id " . $request->documentId . " not found");
        }

        if ($document->docType->documentType == DocumentTypeEnum::POLICE_CLEARANCE) {
            $document->update([
                'verified' => true
            ]);
            return $this->buildSuccessResponse($document, 'Police Clearance successfully verified');
        }
        return $this->buildErrorResponse("The provided document is not a police clearance and cannot be verified ");
    }

    public function verifyNationalId(DocumentVerificationRequest $request): JsonResponse
    {
        $document = Document::query()->firstWhere('id', '=', $request->documentId);
        if (!$document) {
            return $this->buildErrorResponse("Document with id " . $request->documentId . " not found");
        }

        if ($document->docType->documentType == DocumentTypeEnum::NATIONAL_ID) {
            $document->update([
                'verified' => true
            ]);
            return $this->buildSuccessResponse($document, 'National ID successfully verified');
        }
        return $this->buildErrorResponse("The provided document is not a National Identity document and cannot be verified ");
    }

    public function verifyPassport(DocumentVerificationRequest $request): JsonResponse
    {
        $document = Document::query()->firstWhere('id', '=', $request->documentId);
        if (!$document) {
            return $this->buildErrorResponse("Document with id " . $request->documentId . " not found");
        }

        if ($document->docType->documentType == DocumentTypeEnum::PASSPORT) {
            $document->update([
                'verified' => true
            ]);
            return $this->buildSuccessResponse($document, 'Passport successfully verified');
        }
        return $this->buildErrorResponse("The provided document is not a passport and cannot be verified ");
    }

    public function verifyProofOfResidence(DocumentVerificationRequest $request): JsonResponse
    {
        $document = Document::query()->firstWhere('id', '=', $request->documentId);
        if (!$document) {
            return $this->buildErrorResponse("Document with id " . $request->documentId . " not found");
        }

        if ($document->docType->documentType == DocumentTypeEnum::CV) {
            $document->update([
                'verified' => true
            ]);
            return $this->buildSuccessResponse($document, 'Proof of residence successfully verified');
        }
        return $this->buildErrorResponse("The provided document is not a proof of residence and cannot be verified ");
    }
}
