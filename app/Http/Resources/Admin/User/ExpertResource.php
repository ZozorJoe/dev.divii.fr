<?php

namespace App\Http\Resources\Admin\User;

use App\Http\Resources\Admin\Catalog\DisciplineResource;
use App\Http\Resources\Admin\Catalog\FormationResource;
use App\Http\Resources\File\FileResource;
use App\Models\Chat\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * @property mixed description
 * @property mixed durations
 * @property mixed is_active
 * @property mixed order
 */
class ExpertResource extends UserResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $data = parent::toArray($request);
        $data['order'] = $this->order;
        $data['is_active'] = (boolean) $this->is_active;
        $data['description'] = $this->description;
        $data['picto'] = new FileResource($this->whenLoaded('picto'));
        $data['disciplines'] = DisciplineResource::collection($this->whenLoaded('disciplines'));
        $data['formations'] = FormationResource::collection($this->whenLoaded('formations'));

        $loaded = $this->resource->relationLoaded('timeSlots');
        if($loaded){
            $app_timezone = config('app.timezone');
            $user_timezone = $request->get('timezone') ?? $app_timezone;

            $slots = array_fill(0, 7, []);

            /** @var TimeSlot[] $timeSlots */
            $timeSlots = $this->resource->timeSlots;
            foreach ($timeSlots as $timeSlot){
                $weekday = $timeSlot->weekday;
                $start = $this->getDate($timeSlot->start_at, $weekday, $user_timezone);
                if($timeSlot->end_at === '00:00:00'){
                    $end = $this->getDate('23:59:59', $weekday, $user_timezone);
                    $end->addSecond();
                }else{
                    $end = $this->getDate($timeSlot->end_at, $weekday, $user_timezone);
                }
                if($start->isSameDay($end)){
                    $weekday = $start->weekday();
                    $slots[$weekday][] = [
                        $start->format("H:i"),
                        $end->format("H:i"),
                    ];
                }else{
                    $weekday = $start->weekday();
                    $slots[$weekday][] = [
                        $start->format("H:i"),
                        $start->copy()->endOfDay()->addSecond()->format("H:i"),
                    ];

                    $weekday = $end->weekday();
                    $slots[$weekday][] = [
                        $end->copy()->startOfDay()->format("H:i"),
                        $end->format("H:i"),
                    ];
                }

            }

            foreach ($slots as $weekday => $times){
                foreach ($times as $index => $time){
                    if(isset($times[$index + 1]) && $time[1] === $times[$index + 1][0]){
                        $slots[$weekday][$index][1] = $times[$index + 1][1];
                        unset($slots[$weekday][$index + 1]);
                    }
                }
            }

            $data['time_slots'] = $slots;
        }

        return $data;
    }

    private function getDate($time, $weekday, $user_timezone)
    {
        $date = Carbon::createFromFormat("H:i:s", $time)->weekday($weekday)->addDay();
        return $date->timezone($user_timezone);
    }
}
