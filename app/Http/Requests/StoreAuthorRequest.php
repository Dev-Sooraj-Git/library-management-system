<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Temporary: allow everyone
        // Later you can add role check like:
        // return auth()->user()->role === 'admin';
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|string|min:3|max:100|unique:authors,name',
            'email' => 'required|email|max:150|unique:authors,email'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Author Name is Required.',
            'name.unique' => 'This author name already exists',
            'email.unique' => 'This email is already registered for another author'
        ];
    }
}
