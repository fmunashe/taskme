<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateUserProfileRequest extends FormRequest
{

    public function authorize(): bool
    {
        return false;
    }


    public function rules(): array
    {
        return [
            'userId' => 'required',
            'dob' => 'required|date',
            'idNumber' => 'required|string',
            'profession' => 'required|string',
            'highestEductionQualification' => 'required',
            'bio' => 'required',
            'maritalStatus' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'address' => 'required'
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
