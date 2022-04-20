<?php

namespace App\Http\Requests\Expert\Account;

use App\Models\Chat\TimeSlot;
use App\Models\User;
use App\Models\User\Expert;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TimeSlotRequest extends FormRequest
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
            'time_slots' => 'nullable|array',
            'timezone' => 'nullable|string',
        ];
    }

    /**
     * Handle request.
     *
     * @param User $user
     * @param array $data
     * @return Expert|null
     */
    public function handle(User $user, array $data = array()): ?User
    {
        $data = array_merge($this->validated(), $data);
        if(isset($data['time_slots'])){
            $app_timezone = config('app.timezone');
            $user_timezone = $data['timezone'] ?? $app_timezone;

            $user->timeSlots()->delete();
            $timeSlots = $data['time_slots'];
            foreach ($timeSlots as $weekday => $times){
                foreach ($times as $slot){
                    if(isset($slot[0]) && isset($slot[1])){
                        $start = Carbon::createFromFormat("H:i:s", $slot[0].':00', $user_timezone)->weekday($weekday)->subDay();
                        $end = Carbon::createFromFormat("H:i:s", $slot[1].':00', $user_timezone)->weekday($weekday)->subDay();
                        if($start->isBefore(now($user_timezone))){
                            $start = $start->addWeek();
                            $end = $end->addWeek();
                        }
                        $start = $start->timezone($app_timezone);
                        $end = $end->timezone($app_timezone);
                        if($start->isSameDay($end)){
                            $user->timeSlots()->create([
                                'repetition' => TimeSlot::REPETITION_WEEKLY,
                                'weekday' => $start->weekday(),
                                'start_at' => $start,
                                'end_at' => $end,
                            ]);
                        }else{
                            $user->timeSlots()->create([
                                'repetition' => TimeSlot::REPETITION_WEEKLY,
                                'weekday' => $start->weekday(),
                                'start_at' => $start->format('H:i:s'),
                                'end_at' => $start->copy()->endOfDay()->addSecond()->format('H:i:s'),
                            ]);

                            $user->timeSlots()->create([
                                'repetition' => TimeSlot::REPETITION_WEEKLY,
                                'weekday' => $end->weekday(),
                                'start_at' => $end->copy()->startOfDay()->format('H:i:s'),
                                'end_at' => $end->format('H:i:s'),
                            ]);
                        }
                    }
                }
            }
        }

        return $user;
    }
}
