<?php

namespace App\Models\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static findOrFail($id)
 * @method static find(mixed $getKey)
 */
class Expert extends User
{
    const ROLE = 'expert';

    public function isAvailable(Carbon $start, Carbon $end): bool
    {
        $builder = $this->rooms();
        $builder->where(function (Builder $builder) use ($start, $end) {
            // 08:15:00 - 08:30:00 =>

            /* 1-a-b-2 */
            $builder->orWhere(function (Builder $builder) use ($start, $end) {
                $builder->where('rooms.start_at', '<=', $start); // 00:00
                $builder->where('rooms.end_at', '>=', $end); // 15:00
            });
            /* a-1-2-b */
            $builder->orWhere(function (Builder $builder) use ($start, $end) {
                $builder->where('rooms.start_at', '>=', $start); // 00:00
                $builder->where('rooms.end_at', '<=', $end); // 15:00
            });
            /* 1-a-2-b */
            $builder->orWhere(function (Builder $builder) use ($start) {
                $builder->where('rooms.start_at', '<', $start); // 00:00
                $builder->where('rooms.end_at', '>', $start); // 00:00
            });
            /* a-1-b-2 */
            $builder->orWhere(function (Builder $builder) use ($end) {
                $builder->where('rooms.start_at', '<', $end); // 15:00
                $builder->where('rooms.end_at', '>', $end); // 15:00
            });
        });
        $exists = $builder->exists();
        if($exists){
            return false;
        }

        $builder = $this->timeSlots();
        if($start->isSameDay($end)){
            $weekday = $start->weekday();
            $builder->where('time_slots.weekday', '=', $weekday);
            $builder->whereRaw('DATE_FORMAT(time_slots.start_at, "%H:%i") <= ?', $start->format('H:i'));
            $builder->where(function (Builder $builder) use ($end) {
                // 00:00:00
                $builder->orWhereRaw('DATE_FORMAT(DATE_SUB(CONCAT(CURDATE(), " ", time_slots.end_at), INTERVAL 1 SECOND), "%H:%i") >= ?', $end->format('H:i'));
                // else
                $builder->orWhereRaw('DATE_FORMAT(time_slots.end_at, "%H:%i") >= ?', $end->format('H:i'));
            });
            $doesntExist = $builder->doesntExist();
            if($doesntExist){
                return false;
            }
        }else{
            // Verify start date
            $weekday = $start->weekday();
            $builder->where('time_slots.weekday', '=', $weekday);
            $builder->whereRaw('DATE_FORMAT(time_slots.start_at, "%H:%i") <= ?', $start->format('H:i'));
            $builder->where('time_slots.end_at', '=', '00:00:00');
            $doesntExist = $builder->doesntExist();
            if($doesntExist){
                return false;
            }

            // Verify end date
            $weekday = $end->weekday();
            $builder->where('time_slots.weekday', '=', $weekday);
            $builder->where('time_slots.start_at', '=', '00:00:00');
            $builder->whereRaw('DATE_FORMAT(time_slots.end_at, "%H:%i") >= ?', $end->format('H:i'));
            $doesntExist = $builder->doesntExist();
            if($doesntExist){
                return false;
            }
        }

        return true;
    }
}
