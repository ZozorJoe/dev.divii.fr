<?php

namespace App\Http\Requests\Admin\User;

use App\Events\Account\AccountCreated;
use App\Models\Chat\TimeSlot;
use App\Models\User\Expert;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ExpertRequest extends FormRequest
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
        $expert = $this->route('expert');
        return [
            'avatar_id' => 'nullable|numeric|exists:files,id',
            'picto_id' => 'nullable|numeric|exists:files,id',
            'background_color' => 'nullable|string|max:10',
            'order' => 'nullable|numeric',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'description' => 'nullable|string',
            'email' => 'required|email|unique:users,email' . ( $expert ? ',' . (int) $expert->getKey() : '' ),
            'password' => 'nullable|string|confirmed|min:8',
            'disciplines' => 'nullable|array',
            'disciplines.*' => 'nullable|exists:disciplines,id',
            'durations' => 'nullable|array',
            'durations.*' => 'nullable|exists:durations,id',
            'preparations' => 'nullable|array',
            'time_slots' => 'nullable|array',
            'timezone' => 'nullable|timezone',
        ];
    }

    /**
     * Handle request.
     *
     * @param Expert $expert
     * @param array $data
     * @return Expert|null
     */
    public function handle(Expert $expert, array $data = array()): ?Expert
    {
        $data = array_merge($this->validated(), $data);
        if(!$expert->getKey()){
            $data['role'] = Expert::ROLE;

            if(!isset($data['password'])){
                $data['password'] = Str::random(8);
            }

            $expert->email_verified_at = $expert->freshTimestamp();
        }

        $password = null;
        if(isset($data['password'])){
            $password = $data['password'];
            $data['password'] = Hash::make($data['password']);
        }

        $expert->fill($data);
        if($expert->save()){
            if($expert->wasRecentlyCreated){
                event(new AccountCreated($expert, $password));
            }

            if(isset($data['disciplines'])){
                $expert->disciplines()->detach();
                foreach ($data['disciplines'] as $id){
                    $expert->disciplines()->attach($id, [
                        'durations' => $data['durations'][$id] ?? null,
                        'with_preparation' => $data['preparations'][$id] ?? false,
                    ]);
                }
            }

            if(isset($data['time_slots'])){
                $app_timezone = config('app.timezone');
                $user_timezone = $data['timezone'] ?? $app_timezone;

                $expert->timeSlots()->delete();
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
                                $expert->timeSlots()->create([
                                    'repetition' => TimeSlot::REPETITION_WEEKLY,
                                    'weekday' => $start->weekday(),
                                    'start_at' => $start,
                                    'end_at' => $end,
                                ]);
                            }else{
                                $expert->timeSlots()->create([
                                    'repetition' => TimeSlot::REPETITION_WEEKLY,
                                    'weekday' => $start->weekday(),
                                    'start_at' => $start->format('H:i:s'),
                                    'end_at' => $start->copy()->endOfDay()->addSecond()->format('H:i:s'),
                                ]);

                                $expert->timeSlots()->create([
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
            return $expert;
        }
        return null;
    }
}
