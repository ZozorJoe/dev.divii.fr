<?php

namespace App\Listeners\Chat;

use App\Events\Chat\RoomCreated;
use App\Events\Chat\RoomDeleted;
use App\Events\Chat\RoomUpdated;
use App\Events\Order\OrderValidated;
use App\Models\Catalog\Formation;
use App\Models\Chat\Room;
use App\Models\Shop\Consultation;
use App\Models\Shop\Order;
use Illuminate\Database\Eloquent\Builder;

class VerifyRoomAfterRoomUpdated
{
    /**
     * Handle the event.
     *
     * @param RoomUpdated $event
     * @return void
     */
    public function handle(RoomUpdated $event)
    {
        $room = $event->room;
        if(!$room->model instanceof Consultation){
            return;
        }

        /** @var Room $model */
        $model = Room::where('user_id', '=', $room->user_id)
            ->where(function (Builder $builder) use ($room) {
                $builder->orWhere('end_at', '=', $room->start_at);
                $builder->orWhere('start_at', '=', $room->end_at);
            })
            ->whereHasMorph(
                'model',
                [Consultation::class],
                function (Builder $query) use ($room) {
                    $query->where('consultations.customer_id', '=', $room->model->customer_id);
                    $query->where('consultations.discipline_id', '=', $room->model->discipline_id);
                }
            )
            ->where('id', '!=', $room->getKey())
            ->orderBy('start_at')
            ->first();
        if($model){
            if($model->start_at->isBefore($room->start_at)){
                $room->delete();
                event(new RoomDeleted($room));

                $model->end_at = $room->end_at;

                // Create main consultation
                $main = Consultation::associate($model, $room->model);

                // Associate to the room
                $model->model()->associate($main);
                $model->save();

                event(new RoomUpdated($model));
            }else{
                $model->delete();
                event(new RoomDeleted($model));

                $room->end_at = $model->end_at;

                // Create main consultation
                $main = Consultation::associate($room, $model->model);

                // Associate to the room
                $room->model()->associate($main);
                $room->save();

                event(new RoomUpdated($room));
            }
        }
    }
}
