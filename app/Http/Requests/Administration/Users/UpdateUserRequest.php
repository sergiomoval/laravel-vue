<?php

namespace App\Http\Requests\Administration\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('users_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (empty($this->input('password'))) {
            return [
                'name' => 'required',
                'rol' => 'required'
            ];
        }

        return [
            'name' => 'required',
            'password' => 'required|min:6|same:password_confirmation',
            'rol' => 'required'
        ];
    }

     /**
     * Prepare the data after validation.
     *
     * @return void
     */
    protected function passedValidation()
    {
        if (!empty($this->input('password'))) {
            $this->merge(['password' => Hash::make($this->input('password')), 'new-password' => $this->input('password')]);
        }
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (empty($this->input('password'))) {
            $this->offsetUnset('password');
        }
    }
}
