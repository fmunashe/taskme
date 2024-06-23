<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreUserProfileRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'userId' => 'required',
            'dob' => 'required|date|before:today',
            'idNumber' => 'required|string',
            'profession' => 'required|string',
            'highestEductionQualification' => ['required', Rule::in(['Tertiary', 'Secondary', 'Degree', 'Diploma', 'Certificate', 'Ordinary Level Certificate', 'Advanced Level Certificate', 'Grade Seven'])],
            'bio' => 'required',
            'maritalStatus' => ['required', Rule::in(['Married', 'Single', 'Widow', 'Widower'])],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
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
