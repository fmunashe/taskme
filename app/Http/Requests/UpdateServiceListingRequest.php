<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateServiceListingRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_category_id' => 'required|exists:service_categories,id',
            'user_id' => 'required|exists:users,id',
            'record_status_id' => 'required|exists:record_statuses,id',
            'serviceName' => 'required',
            'serviceDescription' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Ops! Some errors occurred',
            'errors' => $validator->errors()->getMessages()
        ]);

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
