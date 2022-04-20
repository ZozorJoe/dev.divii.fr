<?php

namespace App\Listeners\Room;

use App\Events\Chat\RoomCanceled;
use App\Events\User\CreditRefunded;
use App\Models\Shop\Consultation;
use App\Models\Shop\Order;
use App\Models\User;

class RefundCreditWhenRoomCanceled
{
    /**
     * Handle the event.
     *
     * @param  RoomCanceled  $event
     * @return void
     */
    public function handle(RoomCanceled $event)
    {
        $id = md5(time());
        info("$id REFUND CREDIT INIT");

        $room = $event->room;
        $user = $event->user;
        if($room->order && ($room->order->payment_type !== Order::PAYMENT_TYPE_CREDIT)){
            info("$id Payment type " . $room->order->payment_type);
            info("$id REFUND CREDIT SHOULD EXIT");
            //return;
        }

        $model = $room->model;
        if($model instanceof Consultation){
            info("$id Refund A CONSULTATION");
        }else{
            info("$id Refund A FORMATION (exit)");
            info("$id REFUND CREDIT EXIT");
            return;
        }

        $credit = $model->duration ? $model->duration->credit : 0;
        if($credit === 0){
            info("$id Refund CREDIT UNKNOWN");
            info("$id REFUND CREDIT EXIT");
            return;
        }

        if($room->isExpert($user) || $room->isAdmin($user)){
            info("Room cancel by expert or admin (REFUND ALL CREDIT OF ALL CUSTOMER)");
            /** @var User[] $customers */
            $customers = $room->customers()->get();
        }else{
            info("Room cancel by customer (REFUND ONLY THIS CUSTOMER)");
            /** @var User[] $customers */
            $customers = $room->customers()
                ->where('users.id', '=', $user->getKey())
                ->get();

            if($room->start_at){
                if($room->start_at->isAfter(now()->addDay())){
                    info("$id Refund ALL");
                    $credit = $credit + 0;
                } elseif($room->start_at->isAfter(now()->addHours(12))){
                    info("$id Refund 50%");
                    $credit = round($credit / 2);
                } else {
                    info("$id Refund NONE");
                    $credit = 0;
                }
            }else{
                error_log("$id Room with empty start date " . $room->getKey());
                info("$id REFUND CREDIT EXIT");
                return;
            }
        }

        if($credit === 0){
            info("$id Credit is ZERO");
            info("$id REFUND CREDIT EXIT");
            return;
        }

        foreach ($customers as $customer){
            $value = $credit;

            /** @var User\Credit[] $models */
            $models = $customer->credits()
                ->valid()
                ->used()
                ->orderBy('credits.valid_until', 'DESC')
                ->get();

            foreach ($models as $model){
                if($value === 0){
                    continue 2;
                }

                $diff = $model->original_value - $model->value;

                if($value <= $diff){
                    $model->value += $value;
                    $model->save();
                    continue 2;
                }else{
                    // $value > $diff
                    $model->value += $diff;
                    $model->save();
                    $value -= $diff;
                }

            }

            event(new CreditRefunded($customer, $credit, $user));
        }

        info("$id REFUND CREDIT FINISH");
    }
}
