<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreWorkExperienceRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'userId' => 'required',
            'positionHeld' => 'required',
            'startDate' => 'required|date|before:today',
            'endDate' => 'required|date|after:startDate|before:tomorrow',
            'reasonForLeaving' => 'required|min:5',
            'organisation' => 'required|min:3',
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
