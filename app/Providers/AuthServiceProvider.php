<?php

namespace App\Providers;

use App\Models;
use App\Policies;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Models\Catalog\Discipline::class => Policies\Catalog\DisciplinePolicy::class,
        Models\Catalog\Formation::class => Policies\Catalog\FormationPolicy::class,
        Models\Catalog\Product::class => Policies\Catalog\ProductPolicy::class,
        Models\Catalog\Duration::class => Policies\Catalog\DurationPolicy::class,
        Models\Chat\Room::class => Policies\Chat\RoomPolicy::class,
        Models\Chat\Message::class => Policies\Chat\MessagePolicy::class,
        Models\Newsletter\Newsletter::class => Policies\Newsletter\NewsletterPolicy::class,
        Models\Shop\Consultation::class => Policies\Shop\ConsultationPolicy::class,
        Models\Shop\Order::class => Policies\Shop\OrderPolicy::class,
        Models\Shop\Invoice::class => Policies\Shop\InvoicePolicy::class,
        Models\Sale\Coupon::class => Policies\Sale\CouponPolicy::class,
        Models\Sale\Voucher::class => Policies\Sale\VoucherPolicy::class,
        Models\User\Administrator::class => Policies\User\AdministratorPolicy::class,
        Models\User\Customer::class => Policies\User\CustomerPolicy::class,
        Models\User\Expert::class => Policies\User\ExpertPolicy::class,
        Models\User::class => Policies\User\UserPolicy::class,
        Models\Zodiac\Horoscope::class => Policies\Zodiac\HoroscopePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $data = [
                'app_name' => config('app.name'),
                'url' => $url,
                'name' => $notifiable->first_name,
            ];

            return (new MailMessage)
                ->subject(__('emails.auth.verify.subject', $data))
                ->markdown('emails.auth.verify', ['user' => $notifiable, 'data' => $data]);
        });
    }
}
