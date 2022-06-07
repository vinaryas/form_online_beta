<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class UserPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',
                        Rule::unique('users')->where(function ($query) {
                            return $query->where('username', 99);
                        })],
            'username' => ['required', 'string',
                        Rule::unique('users')->where(function ($query) {
                            return $query->where('username', 99);
                        })],
            'role_id' => ['required'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ];
    }
}
