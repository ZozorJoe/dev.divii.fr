<?php

namespace App\Http\Requests\Account;

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
            'status' => 'required|string|max:20',
            'content' => 'nullable|string|max:255',
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
        $user = $this->user();
        $data = array_merge($this->validated(), $data);
        switch ($data['status']){
            case Room::STATUS_CANCELED:
                $room->cancel($data['content'] ?? null, $user);
                return $room;
        }
        return null;
    }
}
