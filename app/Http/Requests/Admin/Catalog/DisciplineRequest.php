<?php

namespace App\Http\Requests\Admin\Catalog;

use App\Models\Catalog\Discipline;
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
            'image_id' => 'nullable|numeric|exists:files,id',
            'picto_id' => 'nullable|numeric|exists:files,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'background_color' => 'nullable|string|max:10',
        ];
    }


    /**
     * Handle request.
     *
     * @param Discipline $discipline
     * @param array $data
     * @return Discipline|null
     */
    public function handle(Discipline $discipline, array $data = array()): ?Discipline
    {
        $data = array_merge($this->validated(), $data);
        $discipline->fill($data);
        if($discipline->save()){
            return $discipline;
        }
        return null;
    }
}
