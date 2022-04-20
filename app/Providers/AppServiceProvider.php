<?php

namespace App\Providers;

use App\Services\Coupon\CouponGenerator;
use App\Services\Coupon\Coupons;
use App\Services\Voucher\VoucherGenerator;
use App\Services\Voucher\Vouchers;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('vouchers', function ($app) {
            $generator = new VoucherGenerator(config('vouchers.characters'), config('vouchers.mask'));
            $generator->setPrefix(config('vouchers.prefix'));
            $generator->setSuffix(config('vouchers.suffix'));
            $generator->setSeparator(config('vouchers.separator'));
            return new Vouchers($generator);
        });
        $this->app->singleton('coupons', function ($app) {
            $generator = new CouponGenerator();
            return new Coupons($generator);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register password helper service
        $this->app->bind('helpers.code', \App\Helpers\Code::class);
        $this->app->bind('helpers.password', \App\Helpers\Password::class);
    }
}
