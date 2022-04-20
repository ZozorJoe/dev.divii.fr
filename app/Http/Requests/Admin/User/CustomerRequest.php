<?php

namespace App\Http\Requests\Admin\User;

use App\Events\Account\AccountCreated;
use App\Models\User\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerRequest extends FormRequest
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
        $customer = $this->route('customer');
        return [
            'avatar_id' => 'nullable|numeric|exists:files,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'email' => 'required|email|unique:users,email' . ( $customer ? ',' . (int) $customer->getKey() : '' ),
            'password' => 'nullable|string|confirmed|min:8',
            'is_tester' => 'nullable|boolean',
        ];
    }

    /**
     * Handle request.
     *
     * @param Customer $customer
     * @param array $data
     * @return Customer|null
     */
    public function handle(Customer $customer, array $data = array()): ?Customer
    {
        $data = array_merge($this->validated(), $data);
        if(!$customer->getKey()){
            $data['role'] = Customer::ROLE;

            if(!isset($data['password'])){
                $data['password'] = Str::random(8);
            }

            $customer->email_verified_at = $customer->freshTimestamp();
        }

        $password = null;
        if(isset($data['password'])){
            $password = $data['password'];
            $data['password'] = Hash::make($data['password']);
        }

        $customer->fill($data);
        if($customer->save()){
            if($customer->wasRecentlyCreated){
                event(new AccountCreated($customer, $password));
            }
            return $customer;
        }

        return null;
    }
}
