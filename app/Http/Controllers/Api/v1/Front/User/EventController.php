<?php

namespace App\Http\Controllers\Api\v1\Front\User;

use App\Http\Controllers\Api\ApiController;
use App\Models\Catalog\Discipline;
use App\Models\Chat\Room;
use App\Models\Chat\TimeSlot;
use App\Models\User\DisciplineUser;
use App\Models\User\Expert;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Expert $expert
     * @param Discipline $discipline
     * @return JsonResponse
     */
    public function index(Request $request, Expert $expert, Discipline $discipline): JsonResponse
    {
        $pivot = DisciplineUser::where('user_id', '=', $expert->getKey())
            ->where('discipline_id', '=', $discipline->getKey())
            ->firstOrFail();

        $min = now()->setSecond(0);
        if($pivot->with_preparation){
            $min = $min->addDay();
        }

        $minute = $min->minute;
        switch ($minute){
            case $minute < 15:
                $min->setMinute(15);
                break;
            case $minute < 30:
                $min->setMinute(30);
                break;
            case $minute < 45:
                $min->setMinute(45);
                break;
            default:
                $min->setMinute(0)->addHour();
                break;
        }

        $user_timezone = $request->get('timezone');
        $app_timezone = config('app.timezone');
        $date = Carbon::parse($request->get('date'));
        $start = $date->copy()->timezone($user_timezone)->startOfMonth()->timezone($app_timezone);
        $end = $date->copy()->timezone($user_timezone)->endOfMonth()->timezone($app_timezone);

        $events = [];

        $delay = 15;
        $date = $start->copy();
        while ($date->isBefore($end)) {
            if(!$date->isPast() && (($date->toDateTimeString() === $min->toDateTimeString()) || $date->isAfter($min))){
                $builder = $expert->rooms();
                $builder->where('rooms.status', '=', Room::STATUS_VALIDATED);
                $builder->where('rooms.start_at', '<=', $date);
                $builder->where('rooms.end_at', '>', $date);
                $room = $builder->first();
                if($room){
                    if($room->end_at && $room->end_at->isAfter($date)){
                        $date = $room->end_at->copy();
                        continue;
                    }
                }else{
                    $builder = $expert->timeSlots();
                    $weekday = $date->weekday();
                    $time = $date->format('H:i');
                    $builder->whereRaw('weekday = ?', $weekday);
                    $builder->whereRaw('DATE_FORMAT(start_at, "%H:%i") <= ?', $time);
                    $builder->where(function (Builder $builder) use ($time) {
                        // 00:00:00
                        $builder->orWhereRaw('DATE_FORMAT(DATE_SUB(CONCAT(CURDATE(), " ", time_slots.end_at), INTERVAL 1 SECOND), "%H:%i") > ?', $time);
                        // else
                        $builder->orWhereRaw('DATE_FORMAT(time_slots.end_at, "%H:%i") > ?', $time);
                    });
                    //$builder->whereRaw('DATE_FORMAT(DATE_SUB(CONCAT(CURDATE(), " ",end_at), INTERVAL 1 SECOND), "%H:%i") > ?', $time);
                    $exists = $builder->exists();
                    if($exists){
                        $event = [
                            'start' => $date->copy()->toAtomString(),
                            'end' => $date->copy()->addMinutes($delay)->toAtomString(),
                        ];

                        $user_date = $date->copy()->timezone($user_timezone);
                        $index = $user_date->format('Y-m-d');
                        if(!isset($events[$index])){
                            $events[$index] = [
                                'date' => $date->toAtomString(),
                                'slots' => []
                            ];
                        }
                        $events[$index]['slots'][] = $event;
                    }
                }
            }

            $date->addMinutes($delay);
        }

        return response()->json([
            'success' => true,
            'data' => $events,
            'min' => $min->toAtomString(),
            'start' => $start->toAtomString(),
            'end' => $end->toAtomString(),
        ]);
    }
}
