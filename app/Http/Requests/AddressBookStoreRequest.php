<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class AddressBookStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->id;

        return [
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('address_book', 'email')->ignore($id),
            ],
            'phone' => [
                'required',
                Rule::unique('address_book', 'phone')->ignore($id),
            ],
            'website' => 'required',
            'gender' => 'required|string|in:male,female,other',
            'age' => 'required|integer|min:0',
            'nationality' => 'required|string',
            'created_by' => 'required|integer',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'   => 'error',
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ],422));

    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'phone.required' => 'Phone is required',
            'phone.unique' => 'Phone is already exist',
            'email.email' => 'Email is not a correct format',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already exist',
            'website.required' => 'Website is required',
            'gender.required' => 'Gender is required',
            'gender.in' => 'Gender should be male,female or other',
            'age.required' => 'Age is required',
            'age.integer' => 'Age should be in number',
            'nationality.required' => 'Nationality is required',
        ];
    }
}
