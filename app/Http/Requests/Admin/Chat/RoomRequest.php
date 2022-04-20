<?php

namespace App\Http\Requests\Admin\Chat;

use App\Models\Chat\Room;
use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'start_at' => 'nullable|datetime',
            'end_at' => 'nullable|datetime',
        ];
    }

    /**
     * Handle request.
     *
     * @param Room $room
     * @param array $data
     * @return Room|null
     */
    public function handle(Room $room, array $data = array()): ?Room
    {
        $data = array_merge($this->validated(), $data);
        $room->fill($data);
        if($room->save()){
            return $room;
        }
        return null;
    }
}
