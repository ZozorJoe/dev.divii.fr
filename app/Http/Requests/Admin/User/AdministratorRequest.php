<?php

namespace App\Http\Requests\Admin\User;

use App\Events\Account\AccountCreated;
use App\Models\User\Administrator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdministratorRequest extends FormRequest
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
        $administrator = $this->route('administrator');
        return [
            'avatar_id' => 'nullable|numeric|exists:files,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'email' => 'required|email|unique:users,email' . ( $administrator ? ',' . (int) $administrator->getKey() : '' ),
            'password' => 'nullable|string|confirmed|min:8',
        ];
    }

    /**
     * Handle request.
     *
     * @param Administrator $administrator
     * @param array $data
     * @return Administrator|null
     */
    public function handle(Administrator $administrator, array $data = array()): ?Administrator
    {
        $data = array_merge($this->validated(), $data);
        if(!$administrator->getKey()){
            $data['role'] = Administrator::ROLE;

            if(!isset($data['password'])){
                $data['password'] = Str::random(8);
            }

            $administrator->email_verified_at = $administrator->freshTimestamp();
        }

        $password = null;
        if(isset($data['password'])){
            $password = $data['password'];
            $data['password'] = Hash::make($data['password']);
        }

        $administrator->fill($data);
        if($administrator->save()){
            if($administrator->wasRecentlyCreated){
                event(new AccountCreated($administrator, $password));
            }
            return $administrator;
        }

        return null;
    }
}
