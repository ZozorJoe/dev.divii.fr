<?php

namespace App\Http\Controllers\Api\v1\Expert\Account;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Expert\Account\TimeSlotRequest;
use App\Models\Catalog\Formation;
use App\Models\Chat\TimeSlot;
use App\Models\Shop\Consultation;
use App\Models\User;
use App\Models\User\Expert;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TimeSlotController extends ApiController
{
    /**
     * Display a dashboard resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $app_timezone = config('app.timezone');
        $user_timezone = $request->get('timezone') ?? $app_timezone;

        $slots = array_fill(0, 7, []);

        /** @var TimeSlot[] $timeSlots */
        $timeSlots = $user->timeSlots()->get();
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

        return response()->json([
            'success' => true,
            'data' => $slots
        ]);
    }

    private function getDate($time, $weekday, $user_timezone)
    {
        $date = Carbon::createFromFormat("H:i:s", $time)->weekday($weekday)->addDay();
        return $date->timezone($user_timezone);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TimeSlotRequest $request
     * @return JsonResponse
     */
    public function update(TimeSlotRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user = $request->handle($user);
        if($user){
            return $this->index($request);
        }

        return response()->json([
            'success' => false,
        ]);
    }
}
