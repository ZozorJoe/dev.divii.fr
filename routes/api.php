<?php

use App\Http\Controllers\Api\v1;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')
    ->group(function () {
        Route::get('timezones', [v1\Utils\TzController::class, 'index'])->name('timezones');

        Route::post('login', [v1\Auth\LoginController::class, 'store'])->name('login');
        Route::post('register', [v1\Auth\RegisterController::class, 'store'])->name('register');
        Route::post('welcome', [v1\Auth\WelcomeController::class, 'store'])->name('welcome');
        Route::post('password-reset', [v1\Auth\PasswordResetController::class, 'store'])->name('password.reset');
        Route::get('new-password/{email}/{token}', [v1\Auth\NewPasswordController::class, 'create'])->name('new.password');
        Route::post('new-password', [v1\Auth\NewPasswordController::class, 'store'])->name('new.password.store');
        Route::middleware('auth:sanctum')
            ->group(function () {
                Route::any('logout', [v1\Auth\LogoutController::class, 'destroy'])->name('logout');
                Route::get('account', [v1\Account\AccountController::class, 'show'])->name('account.show');
                Route::put('account', [v1\Account\AccountController::class, 'update'])->name('account.update');

                Route::prefix('account')
                    ->name('account.')
                    ->group(function () {
                        Route::get('notifications', [v1\Account\NotificationController::class, 'index'])->name('notifications.index');
                        Route::put('notifications/{id}', [v1\Account\NotificationController::class, 'mark'])->name('notifications.mark');
                        Route::put('notifications', [v1\Account\NotificationController::class, 'markAll'])->name('notifications.mark.all');
                        Route::delete('notifications/{id}', [v1\Account\NotificationController::class, 'destroy'])->name('notifications.destroy');
                        Route::delete('notifications', [v1\Account\NotificationController::class, 'massDelete'])->name('notifications.mass.delete');

                        Route::resource('rooms', v1\Account\Room\RoomController::class)->except(['create', 'edit']);
                        Route::resource('rooms.messages', v1\Account\Room\MessageController::class)->except(['create', 'edit'])->shallow();
                        Route::resource('rooms.users', v1\Account\Room\UserController::class)->except(['create', 'edit'])->shallow();
                        Route::post('rooms/{room:id}/signal', [v1\Account\Room\SignalController::class, 'store'])->name('rooms.signal');

                        Route::post('rooms/{room:id}/ratings', [v1\Account\RatingController::class, 'store'])->name('ratings.store');
                    });

                Route::prefix('admin')
                    ->name('admin.')
                    ->middleware('role:administrator')
                    ->group(function () {
                        Route::resource('formations', v1\Admin\Catalog\FormationController::class)->except(['create', 'edit']);
                        Route::delete('formations', [v1\Admin\Catalog\FormationController::class, 'massDelete'])->name('formations.delete.mass');
                        Route::resource('disciplines', v1\Admin\Catalog\Discipline\DisciplineController::class)->except(['create', 'edit']);
                        Route::put('disciplines/{discipline}/toggle', [v1\Admin\Catalog\Discipline\DisciplineController::class, 'toggle'])->name('disciplines.toggle');
                        Route::get('disciplines/{discipline}/experts', [v1\Admin\Catalog\Discipline\ExpertController::class, 'index'])->name('disciplines.experts.index');
                        Route::post('disciplines/{discipline}/experts/{id}/toggle', [v1\Admin\Catalog\Discipline\ExpertController::class, 'toggle'])->name('disciplines.experts.toggle');
                        Route::post('disciplines/{discipline}/experts/attach', [v1\Admin\Catalog\Discipline\ExpertController::class, 'massAttach'])->name('disciplines.experts.attach.mass');
                        Route::delete('disciplines/{discipline}/experts/detach', [v1\Admin\Catalog\Discipline\ExpertController::class, 'massDetach'])->name('disciplines.experts.detach.mass');
                        Route::delete('disciplines/{discipline}/experts/{id}', [v1\Admin\Catalog\Discipline\ExpertController::class, 'destroy'])->name('disciplines.experts.destroy');
                        Route::delete('disciplines/{discipline}/experts', [v1\Admin\Catalog\Discipline\ExpertController::class, 'massDelete'])->name('disciplines.experts.delete.mass');
                        Route::delete('disciplines', [v1\Admin\Catalog\Discipline\DisciplineController::class, 'massDelete'])->name('disciplines.delete.mass');
                        Route::resource('products', v1\Admin\Catalog\ProductController::class)->except(['create', 'edit']);
                        Route::delete('products', [v1\Admin\Catalog\ProductController::class, 'massDelete'])->name('products.delete.mass');
                        Route::resource('durations', v1\Admin\Catalog\DurationController::class)->except(['create', 'edit']);
                        Route::delete('durations', [v1\Admin\Catalog\DurationController::class, 'massDelete'])->name('durations.delete.mass');
                        Route::prefix('sale')
                            ->name('sale.')
                            ->group(function () {
                                Route::get('consultations', [v1\Admin\Sale\ConsultationController::class, 'index'])->name('consultations.index');
                                Route::get('consultations/{room}', [v1\Admin\Sale\ConsultationController::class, 'show'])->name('consultations.show');
                                Route::put('consultations/{room}', [v1\Admin\Sale\ConsultationController::class, 'update'])->name('consultations.update');
                                Route::delete('consultations/{room}', [v1\Admin\Sale\ConsultationController::class, 'destroy'])->name('consultations.destroy');
                                Route::delete('consultations', [v1\Admin\Sale\ConsultationController::class, 'massDelete'])->name('consultations.delete.mass');

                                Route::get('formations', [v1\Admin\Sale\FormationController::class, 'index'])->name('formations.index');
                                Route::get('formations/{room}', [v1\Admin\Sale\FormationController::class, 'show'])->name('formations.show');
                                Route::put('formations/{room}', [v1\Admin\Sale\FormationController::class, 'update'])->name('formations.update');
                                Route::delete('formations/{room}', [v1\Admin\Sale\FormationController::class, 'destroy'])->name('formations.destroy');
                                Route::delete('formations', [v1\Admin\Sale\FormationController::class, 'massDelete'])->name('formations.delete.mass');

                            });

                        Route::resource('coupons', v1\Admin\Sale\CouponController::class)->except(['create', 'edit']);
                        Route::delete('coupons', [v1\Admin\Sale\CouponController::class, 'massDelete'])->name('coupons.delete.mass');
                        Route::put('coupons/{coupon}/toggle', [v1\Admin\Sale\CouponController::class, 'toggle'])->name('coupons.toggle');
                        Route::resource('vouchers', v1\Admin\Sale\VoucherController::class)->except(['create', 'edit']);
                        Route::delete('vouchers', [v1\Admin\Sale\VoucherController::class, 'massDelete'])->name('vouchers.delete.mass');

                        Route::resource('orders', v1\Admin\Shop\OrderController::class)->except(['create', 'edit']);
                        Route::delete('orders', [v1\Admin\Shop\OrderController::class, 'massDelete'])->name('orders.delete.mass');
                        Route::put('orders/{order}/{status}', [v1\Admin\Shop\OrderController::class, 'changeStatus'])->name('orders.change.status');
                        Route::resource('invoices', v1\Admin\Shop\InvoiceController::class)->except(['create', 'edit']);
                        Route::resource('customers', v1\Admin\User\CustomerController::class)->except(['create', 'edit']);
                        Route::delete('customers', [v1\Admin\User\CustomerController::class, 'massDelete'])->name('customers.delete.mass');
                        Route::resource('administrators', v1\Admin\User\AdministratorController::class)->except(['create', 'edit']);
                        Route::delete('administrators', [v1\Admin\User\AdministratorController::class, 'massDelete'])->name('administrators.delete.mass');
                        Route::resource('users', v1\Admin\User\UserController::class)->except(['create', 'edit']);
                        Route::delete('users', [v1\Admin\User\UserController::class, 'massDelete'])->name('users.delete.mass');
                        Route::resource('horoscopes', v1\Admin\Zodiac\HoroscopeController::class)->except(['create', 'edit']);
                        Route::delete('horoscopes', [v1\Admin\Zodiac\HoroscopeController::class, 'massDelete'])->name('horoscopes.delete.mass');
                        Route::resource('newsletters', v1\Admin\Newsletter\NewsletterController::class)->except(['create', 'edit']);
                        Route::delete('newsletters', [v1\Admin\Newsletter\NewsletterController::class, 'massDelete'])->name('newsletters.delete.mass');
                        Route::get('inscriptions', [v1\Admin\User\InscriptionController::class, 'index'])->name('inscriptions.index');
                        Route::delete('inscriptions/{customer}', [v1\Admin\User\InscriptionController::class, 'destroy'])->name('inscriptions.destroy');
                        Route::delete('inscriptions', [v1\Admin\User\InscriptionController::class, 'massDelete'])->name('inscriptions.delete.mass');

                        Route::prefix('experts')
                            ->name('experts.')
                            ->group(function () {
                                Route::resource('invoices', v1\Admin\User\Expert\InvoiceController::class)->only(['index', 'destroy']);
                                Route::delete('invoices', [v1\Admin\User\Expert\InvoiceController::class, 'massDelete'])->name('invoices.delete.mass');
                                Route::resource('ratings', v1\Admin\User\Expert\RatingController::class)->only(['index', 'destroy']);
                                Route::delete('ratings', [v1\Admin\User\Expert\RatingController::class, 'massDelete'])->name('ratings.delete.mass');
                                Route::put('ratings/{rating}/{status}', [v1\Admin\User\Expert\RatingController::class, 'changeStatus'])->name('ratings.change.status');
                            });
                        Route::resource('experts', v1\Admin\User\Expert\ExpertController::class)->except(['create', 'edit']);
                        Route::delete('experts', [v1\Admin\User\Expert\ExpertController::class, 'massDelete'])->name('experts.delete.mass');
                        Route::put('experts/{expert}/toggle', [v1\Admin\User\Expert\ExpertController::class, 'toggle'])->name('experts.toggle');

                    });

                Route::prefix('expert')
                    ->name('expert.')
                    ->middleware('role:expert')
                    ->group(function () {
                        Route::post('contact', [v1\Expert\Contact\ContactController::class, 'store'])->name('contact.store');
                        Route::get('account', [v1\Expert\Account\AccountController::class, 'show'])->name('account.show');
                        Route::get('account/dashboard', [v1\Expert\Account\DashboardController::class, 'index'])->name('account.dashboard');
                        Route::put('account/disciplines', [v1\Expert\Account\DisciplineController::class, 'update'])->name('account.disciplines.update');
                        Route::get('account/time-slots', [v1\Expert\Account\TimeSlotController::class, 'index'])->name('account.time-slots');
                        Route::put('account/time-slots', [v1\Expert\Account\TimeSlotController::class, 'update'])->name('account.time-slots.update');
                        Route::resource('formations', v1\Expert\Catalog\FormationController::class)->except(['create', 'edit']);
                        Route::resource('disciplines', v1\Expert\Catalog\DisciplineController::class)->only(['index']);
                        Route::resource('durations', v1\Expert\Catalog\DurationController::class)->only(['index']);
                        Route::resource('invoices', v1\Expert\Shop\InvoiceController::class)->except(['create', 'edit']);
                        Route::resource('users', v1\Expert\User\UserController::class)->only(['show']);
                        Route::put('invoices/{invoice}/{status}', [v1\Expert\Shop\InvoiceController::class, 'changeStatus'])->name('invoices.change.status');

                        Route::prefix('sale')
                            ->name('sale.')
                            ->group(function () {
                                Route::get('consultations', [v1\Expert\Sale\ConsultationController::class, 'index'])->name('consultations.index');
                                Route::get('consultations/events', [v1\Expert\Sale\ConsultationController::class, 'events'])->name('consultations.events');
                                Route::get('consultations/{room}', [v1\Expert\Sale\ConsultationController::class, 'show'])->name('consultations.show');
                                Route::put('consultations/{room}', [v1\Expert\Sale\ConsultationController::class, 'update'])->name('consultations.update');
                                Route::delete('consultations/{room}', [v1\Expert\Sale\ConsultationController::class, 'destroy'])->name('consultations.destroy');
                                Route::delete('consultations', [v1\Expert\Sale\ConsultationController::class, 'massDelete'])->name('consultations.delete.mass');

                                Route::resource('invoices', v1\Expert\Shop\InvoiceController::class)->except(['create', 'edit']);

                                Route::get('formations', [v1\Expert\Sale\FormationController::class, 'index'])->name('formations.index');
                                Route::get('formations/events', [v1\Expert\Sale\FormationController::class, 'events'])->name('formations.events');
                                Route::get('formations/{room}', [v1\Expert\Sale\FormationController::class, 'show'])->name('formations.show');
                                Route::put('formations/{room}', [v1\Expert\Sale\FormationController::class, 'update'])->name('formations.update');
                                Route::delete('formations/{room}', [v1\Expert\Sale\FormationController::class, 'destroy'])->name('formations.destroy');
                                Route::delete('formations', [v1\Expert\Sale\FormationController::class, 'massDelete'])->name('formations.delete.mass');
                            });
                    });

                Route::prefix('customer')
                    ->name('customer.')
                    ->middleware('role:customer')
                    ->group(function () {
                        Route::post('contact', [v1\Customer\Contact\ContactController::class, 'store'])->name('contact.store');
                        Route::get('account/dashboard', [v1\Customer\Account\DashboardController::class, 'index'])->name('account.dashboard');
                        Route::resource('orders', v1\Customer\Shop\OrderController::class)->except(['create', 'edit']);
                        Route::resource('invoices', v1\Customer\Shop\InvoiceController::class)->except(['create', 'edit']);
                        Route::prefix('sale')
                            ->name('sale.')
                            ->group(function () {
                                Route::get('consultations', [v1\Customer\Sale\ConsultationController::class, 'index'])->name('consultations.index');
                                Route::get('consultations/events', [v1\Customer\Sale\ConsultationController::class, 'events'])->name('consultations.events');
                                Route::get('consultations/{room}', [v1\Customer\Sale\ConsultationController::class, 'show'])->name('consultations.show');
                                Route::put('consultations/{room}', [v1\Customer\Sale\ConsultationController::class, 'update'])->name('consultations.update');
                                Route::delete('consultations/{room}', [v1\Customer\Sale\ConsultationController::class, 'destroy'])->name('consultations.destroy');
                                Route::delete('consultations', [v1\Customer\Sale\ConsultationController::class, 'massDelete'])->name('consultations.delete.mass');

                                Route::get('formations', [v1\Customer\Sale\FormationController::class, 'index'])->name('formations.index');
                                Route::get('formations/events', [v1\Customer\Sale\FormationController::class, 'events'])->name('formations.events');
                                Route::get('formations/{room}', [v1\Customer\Sale\FormationController::class, 'show'])->name('formations.show');
                                Route::put('formations/{room}', [v1\Customer\Sale\FormationController::class, 'update'])->name('formations.update');
                                Route::delete('formations/{room}', [v1\Customer\Sale\FormationController::class, 'destroy'])->name('formations.destroy');
                                Route::delete('formations', [v1\Customer\Sale\FormationController::class, 'massDelete'])->name('formations.delete.mass');
                            });
                    });

                Route::post('upload/avatar', [v1\File\AvatarController::class, 'upload'])->name('upload.avatar');
                Route::post('upload/file', [v1\File\FileController::class, 'upload'])->name('upload.file');
            });
        Route::resource('formations', v1\Front\Catalog\FormationController::class)->only(['index', 'show']);
        Route::resource('disciplines', v1\Front\Catalog\Discipline\DisciplineController::class)->only(['index', 'show']);
        Route::resource('disciplines.formations', v1\Front\Catalog\Discipline\FormationController::class)->only(['index']);
        Route::resource('disciplines.experts', v1\Front\Catalog\Discipline\ExpertController::class)->only(['index']);
        Route::resource('products', v1\Front\Catalog\ProductController::class)->only(['index', 'show']);
        Route::resource('experts', v1\Front\User\ExpertController::class)->only(['index', 'show']);
        Route::resource('experts.durations', v1\Front\User\DurationController::class)->only(['index']);
        Route::resource('experts.disciplines', v1\Front\User\DisciplineController::class)->only(['index']);
        Route::resource('experts.disciplines.events', v1\Front\User\EventController::class)->only(['index']);
        Route::resource('experts.disciplines.durations', v1\Front\User\DurationController::class)->only(['index']);
        Route::resource('experts.disciplines.consultations', v1\Front\User\ConsultationController::class)->only(['store']);
        Route::resource('experts.formations', v1\Front\User\FormationController::class)->only(['index']);
        Route::resource('experts.rooms', v1\Front\Shop\RoomController::class)->only(['store']);
        Route::resource('carts', v1\Front\Shop\CartController::class)->except(['show', 'create', 'edit'])->parameters(['carts' => 'order']);
        Route::get('disciplines/{discipline}/experts', [v1\Front\User\ExpertController::class, 'index'])->name('disciplines.experts.index');
        Route::post('checkout', [v1\Front\Shop\CheckoutController::class, 'store'])->name('checkout');
        Route::post('voucher', [v1\Front\Shop\VoucherController::class, 'store'])->name('voucher');
        Route::post('coupon', [v1\Front\Shop\CouponController::class, 'store'])->name('coupon');
        Route::post('newsletter', [v1\Front\User\NewsletterController::class, 'store'])->name('newsletter');
        Route::get('calendar/formations', [v1\Front\Calendar\FormationController::class, 'index'])->name('calendar.formations.index');

        Route::post('trackers', [v1\Utils\TrackerController::class, 'store'])->name('trackers.store');
    });

