<?php

namespace App\Http\Requests\Admin\Catalog;

use App\Models\Catalog\Duration;
use Illuminate\Foundation\Http\FormRequest;

class DurationRequest extends FormRequest
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
            'label' => 'required|string|max:150',
            'credit' => 'required|numeric',
            'price' => 'required|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'currency' => 'required|string|min:3|max:3',
            'delay' => 'required|string|max:50',
        ];
    }

    /**
     * Handle request.
     *
     * @param Duration $duration
     * @param array $data
     * @return Duration|null
     */
    public function handle(Duration $duration, array $data = array()): ?Duration
    {
        $data = array_merge($this->validated(), $data);
        $duration->fill($data);
        if($duration->save()){
            return $duration;
        }
        return null;
    }
}
