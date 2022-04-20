<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $id = '';
        $user = $this->route('user');
        if($user instanceof User){
            $id = ',' . $user->getKey();
        }

        return [
            'avatar_id' => 'nullable|numeric|exists:files,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email' . $id,
            'password' => 'nullable|string|confirmed|min:8',
            'role' => 'nullable|string',
        ];
    }

    /**
     * Handle request.
     *
     * @param User $user
     * @param array $data
     * @return User|null
     */
    public function handle(User $user, array $data = array()): ?User
    {
        $data = array_merge($this->validated(), $data);
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }
        $user->fill($data);
        if($user->save()){
            return $user;
        }
        return null;
    }
}
