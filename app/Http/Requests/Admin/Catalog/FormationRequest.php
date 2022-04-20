<?php

namespace App\Http\Requests\Admin\Catalog;

use App\Models\Catalog\Formation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class FormationRequest extends FormRequest
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
            'price' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|min:3|max:3',
            'start_at' => 'nullable|date',
            'duration' => 'nullable|numeric|min:0',
            'user_id' => 'nullable|numeric|exists:users,id',
            'background_color' => 'nullable|string|max:10',
            'disciplines' => 'nullable|array',
            'disciplines.*' => 'nullable|exists:disciplines,id',
        ];
    }

    /**
     * Handle request.
     *
     * @param Formation $formation
     * @param array $data
     * @return Formation|null
     */
    public function handle(Formation $formation, array $data = array()): ?Formation
    {
        $data = array_merge($this->validated(), $data);
        $format = 'Y-m-d H:i:s';

        $start = null;
        if(isset($data['start_at'])){
            $start = Carbon::createFromFormat($format, date($format, strtotime($data['start_at'])));
        }
        $data['start_at'] = $start;

        if($start && isset($data['duration'])){
            $data['end_at'] = $start->copy()->addHours($data['duration']);
        }else{
            $data['end_at'] = null;
        }

        $formation->fill($data);
        if($formation->save()){
            if(isset($data['disciplines'])){
                $formation->disciplines()->sync($data['disciplines']);
            }
            return $formation;
        }
        return null;
    }
}
