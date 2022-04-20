<?php

namespace App\Listeners\Shop;

use App\Events\Chat\RoomCreated;
use App\Events\Chat\RoomUpdated;
use App\Events\Order\OrderValidated;
use App\Models\Catalog\Formation;
use App\Models\Chat\Room;
use App\Models\Shop\Consultation;
use App\Models\Shop\Order;
use Illuminate\Database\Eloquent\Builder;

class CreateRoomAfterOrderValidated
{
    /**
     * Handle the event.
     *
     * @param OrderValidated $event
     * @return void
     */
    public function handle(OrderValidated $event)
    {
        $order = $event->order;
        if($order){
            $items = $order->items;
            foreach ($items as $item){
                $model = $item->orderable;
                switch (true){
                    case $model instanceof Formation:
                        $this->createFormationRoom($order, $model);
                    break;
                    case $model instanceof Consultation:
                        $this->createConsultationRoom($order, $model);
                    break;
                }
            }
        }
    }

    private function createFormationRoom(Order $order, Formation $formation)
    {
        /** @var Room $room */
        $room = Room::where('rooms.model_id', '=', $formation->getKey())
            ->where('rooms.model_type', '=', get_class($formation))
            ->first();
        if(!$room){
            $room = Room::create(
                [
                    'start_at' => $formation->start_at,
                    'end_at' => $formation->end_at,
                    'title' => $formation->name,
                    'user_id' => $formation->user_id,
                    'order_id' => $order->getKey(),
                    'model_id' => $formation->getKey(),
                    'model_type' => get_class($formation),
                ]
            );

            // attach expert
            $room->users()->attach($formation->user_id);

            // Trigger event
            event(new RoomCreated($room, $formation->user));
        }

        // attach customer
        $room->users()->attach($order->user_id);
    }

    private function createConsultationRoom(Order $order, Consultation $consultation)
    {
        /*
        $room = Room::where('user_id', '=', $consultation->expert_id)
            ->where(function (Builder $builder) use ($consultation) {
                $builder->orWhere('end_at', '=', $consultation->start_at);
                $builder->orWhere('start_at', '=', $consultation->end_at);
            })
            ->whereHasMorph(
                'model',
                [Consultation::class],
                function (Builder $query) use ($consultation) {
                    $query->where('consultations.customer_id', '=', $consultation->customer_id);
                    $query->where('consultations.discipline_id', '=', $consultation->discipline_id);
                }
            )
            ->orderBy('start_at')
            ->first();
        if($room){
            if($consultation->start_at->isBefore($room->start_at)){
                $room->start_at = $consultation->start_at;
            }else{
                $room->end_at = $consultation->end_at;
            }

            // Create main consultation
            $main = Consultation::associate($room, $consultation);

            // Associate to the room
            $room->model()->associate($main);
            $room->save();

            // Trigger event
            event(new RoomUpdated($room));
        }else{
            // Create room
            $room = Room::create(
                [
                    'start_at' => $consultation->start_at,
                    'end_at' => $consultation->end_at,
                    'title' => $consultation->label,
                    'order_id' => $order->getKey(),
                    'user_id' => $consultation->expert_id,
                    'model_id' => $consultation->getKey(),
                    'model_type' => get_class($consultation),
                ]
            );

            // Attach expert
            $room->attachUser($room->user_id);

            // Trigger event
            event(new RoomCreated($room, $room->user));
        }
        */

        // Create room
        $room = Room::create(
            [
                'start_at' => $consultation->start_at,
                'end_at' => $consultation->end_at,
                'title' => $consultation->label,
                'order_id' => $order->getKey(),
                'user_id' => $consultation->expert_id,
                'model_id' => $consultation->getKey(),
                'model_type' => get_class($consultation),
            ]
        );

        // Attach expert
        $room->attachUser($room->user_id);

        // Trigger event
        event(new RoomCreated($room, $room->user));

        // Attach user
        $attached = $room->attachUser($order->user_id);
        if($attached){
            event(new RoomCreated($room, $order->user));
        }

        // Validate consultation
        $consultation->validate();
    }
}
