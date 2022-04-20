<?php

namespace App\Http\Requests\Expert\Account;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class DisciplineRequest extends FormRequest
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
        return [
            'disciplines' => 'nullable|array',
            'disciplines.*' => 'nullable|exists:disciplines,id',
            'durations' => 'nullable|array',
            'durations.*' => 'nullable|exists:durations,id',
            'preparations' => 'nullable|array',
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
        if($user->save()){
            if(isset($data['disciplines'])){
                $user->disciplines()->detach();
                foreach ($data['disciplines'] as $id){
                    $user->disciplines()->attach($id, [
                        'durations' => $data['durations'][$id] ?? null,
                        'with_preparation' => $data['preparations'][$id] ?? false,
                    ]);
                }
            }
            return $user;
        }
        return null;
    }
}
