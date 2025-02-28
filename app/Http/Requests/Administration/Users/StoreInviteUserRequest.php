<?php

namespace App\Http\Requests\Administration\Users;

use App\Models\Invite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class StoreInviteUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('users_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (Invite::where('email', $this->input('email'))->exists()) {
                    $validator->errors()->add(
                        'email',
                        'Something is wrong with this field!'
                    );
                }
            }
        ];
    }
}
