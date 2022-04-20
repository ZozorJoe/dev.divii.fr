<?php

namespace App\Providers;

use App\Events\Account\AccountCreated;
use App\Events\Auth\Registered;
use App\Events\Chat\RoomCanceled;
use App\Events\Chat\RoomCreated;
use App\Events\Chat\RoomUpdated;
use App\Events\Contact\Contact;
use App\Events\Order\Checkout;
use App\Events\Order\OrderComplete;
use App\Events\Order\OrderValidated;
use App\Events\Sale\CouponCreated;
use App\Events\User\UserCreated;
use App\Events\User\UserWelcome;
use App\Events\Zodiac\HoroscopeCreated;
use App\Events\Zodiac\HoroscopeUpdated;
use App\Listeners\Account\SendAccountCreatedNotification;
use App\Listeners\Chat\DispatchReminderNotification;
use App\Listeners\Chat\SendRoomCreatedNotification;
use App\Listeners\Chat\VerifyRoomAfterRoomUpdated;
use App\Listeners\Checkout\RemoveCardSession;
use App\Listeners\Contact\SendContactEmail;
use App\Listeners\Order\SendOrderCompleteNotification;
use App\Listeners\Room\RefundCreditWhenRoomCanceled;
use App\Listeners\Room\SendRoomCanceledNotification;
use App\Listeners\Shop\AddCreditAfterOrderValidated;
use App\Listeners\Shop\CompleteOrderAfterOrderValidated;
use App\Listeners\Shop\CreateInvoiceAfterOrderComplete;
use App\Listeners\Shop\CreateRoomAfterOrderValidated;
use App\Listeners\Shop\MarkCouponAfterOrderValidated;
use App\Listeners\User\CreateTimeSlotAfterUserCreated;
use App\Listeners\User\GenerateCoupon;
use App\Listeners\User\SendCouponNotification;
use App\Listeners\User\SendUserCouponNotification;
use App\Listeners\User\SendWelcomeNotification;
use App\Listeners\Zodiac\SendHoroscopeNotification;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\User;
use App\Observers\Shop\OrderItemObserver;
use App\Observers\Shop\OrderObserver;
use App\Observers\User\AdministratorObserver;
use App\Observers\User\CustomerObserver;
use App\Observers\User\ExpertObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendWelcomeNotification::class,
            SendEmailVerificationNotification::class,
            SendCouponNotification::class,
        ],
        Checkout::class => [
            RemoveCardSession::class,
        ],
        OrderValidated::class => [
            CreateRoomAfterOrderValidated::class,
            AddCreditAfterOrderValidated::class,
            CompleteOrderAfterOrderValidated::class,
            MarkCouponAfterOrderValidated::class,
        ],
        OrderComplete::class => [
            CreateInvoiceAfterOrderComplete::class,
            SendOrderCompleteNotification::class,
        ],
        RoomUpdated::class => [
            VerifyRoomAfterRoomUpdated::class,
        ],
        RoomCanceled::class => [
            SendRoomCanceledNotification::class,
            RefundCreditWhenRoomCanceled::class,
        ],
        RoomCreated::class => [
            SendRoomCreatedNotification::class,
            DispatchReminderNotification::class,
        ],
        UserCreated::class => [
            CreateTimeSlotAfterUserCreated::class,
        ],
        UserWelcome::class => [
            GenerateCoupon::class,
        ],
        Contact::class => [
            SendContactEmail::class,
        ],
        AccountCreated::class => [
            SendAccountCreatedNotification::class,
        ],
        HoroscopeCreated::class => [
            SendHoroscopeNotification::class,
        ],
        HoroscopeUpdated::class => [
            SendHoroscopeNotification::class,
        ],
        CouponCreated::class => [
            SendUserCouponNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        OrderItem::observe(OrderItemObserver::class);

        User::observe(UserObserver::class);
        User\Expert::observe(ExpertObserver::class);
        User\Customer::observe(CustomerObserver::class);
        User\Administrator::observe(AdministratorObserver::class);
    }
}
