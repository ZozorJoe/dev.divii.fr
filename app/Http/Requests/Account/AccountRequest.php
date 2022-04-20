<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'old_password' => 'nullable|string',
            'password' => 'nullable|string|confirmed|min:8',
            'avatar_id' => 'nullable|numeric|exists:files,id',
            'rib' => 'nullable|string',
            'arc' => 'nullable|string',
        ];
    }
}
