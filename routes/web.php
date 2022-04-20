<?php

use App\Http\Controllers\Web;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/ipn/sogecom', [Web\WebHook\SoGeComController::class, 'index'])->name('ipn.sogecom');

Route::middleware('verified')
    ->group(function(){
        Route::get('/account/chat', [Web\Account\ChatController::class, 'index'])->middleware('auth')->name('chat');
        Route::get('/account/chat/{room}', [Web\Account\ChatController::class, 'show'])->middleware('auth')->name('chat.room');
        Route::get('/account/rooms/{room}/cancel', [Web\Account\RoomController::class, 'cancel'])->middleware('auth')->name('chat.room.cancel');
        Route::get('/account/video/{room}', [Web\Account\VideoController::class, 'show'])->middleware('auth')->name('video.room');
        Route::get('/account/invoices/{invoice}', [Web\Account\InvoiceController::class, 'show'])->middleware('auth')->name('account.invoices.show');

        Route::get('/admin/download/invoices/{type}', [Web\Admin\InvoiceController::class, 'download'])->middleware('role:administrator')->name('administrator.invoices.download');
        Route::get('/admin/download/inscriptions', [Web\Admin\InscriptionController::class, 'download'])->middleware('role:administrator')->name('administrator.download.inscriptions');
        Route::get('/admin/download/orders', [Web\Admin\OrderController::class, 'download'])->middleware('role:administrator')->name('administrator.download.orders');
        Route::get('/admin/invoices', [Web\Admin\InvoiceController::class, 'export'])->middleware('role:administrator')->name('administrator.invoices.export');
        Route::get('/admin/{any?}', [Web\AppController::class, 'index'])->middleware('role:administrator')->name('admin')->where('any', '.*');
        Route::get('/expert/{any?}', [Web\AppController::class, 'index'])->middleware('role:expert')->name('expert')->where('any', '.*');
        Route::get('/customer/{any?}', [Web\AppController::class, 'index'])->middleware('role:customer')->name('customer')->where('any', '.*');
    });
Route::get('/qui-nous-sommes', [Web\PageController::class, 'about'])->name('page.about');
Route::get('/terms-of-use', [Web\PageController::class, 'terms'])->name('page.terms');
Route::get('/privacy-policy', [Web\PageController::class, 'policy'])->name('page.policy');
Route::get('/cookie-preferences', [Web\PageController::class, 'cookie'])->name('page.cookie');
Route::get('/accessibility', [Web\PageController::class, 'accessibility'])->name('page.accessibility');

Route::get('/auth/login', [Web\Auth\AuthController::class, 'index'])->middleware('guest')->name('login');
Route::get('/auth/register', [Web\Auth\AuthController::class, 'index'])->middleware('guest')->name('register');
Route::get('/auth/password-reset', [Web\Auth\AuthController::class, 'index'])->middleware('guest')->name('password.reset');
Route::get('/auth/new-password/{email}/{token}', [Web\Auth\AuthController::class, 'index'])->middleware('guest')->name('new.password');
Route::get('/auth/logout', [Web\Auth\AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/auth/email/verify', [Web\Auth\EmailVerificationController::class, 'index'])->middleware('auth')->name('verification.notice');
Route::get('/auth/email/verify/{id}/{hash}', [Web\Auth\EmailVerificationController::class, 'update'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/auth/email/verify', [Web\Auth\EmailVerificationController::class, 'store'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/', [Web\IndexController::class, 'index'])->name('home');
Route::get('/welcome', [Web\IndexController::class, 'welcome'])->name('welcome');
Route::get('/voucher', [Web\IndexController::class, 'index'])->name('voucher');
Route::get('/tarifs', [Web\IndexController::class, 'index'])->name('tarifs');
Route::get('/cgv', [Web\IndexController::class, 'index'])->name('cgv');
Route::get('/cgu', [Web\IndexController::class, 'index'])->name('cgu');
Route::get('/politique-de-confidentialite', [Web\IndexController::class, 'index'])->name('politique');
Route::get('/mentions-legales', [Web\IndexController::class, 'index'])->name('mentions');
Route::get('/cart', [Web\IndexController::class, 'index'])->name('cart');
Route::get('/checkout', [Web\IndexController::class, 'index'])->name('checkout');
Route::get('/experts', [Web\IndexController::class, 'index'])->name('experts.index');
Route::get('/experts/{expert}', [Web\IndexController::class, 'index'])->name('experts.view');
Route::get('/experts/{expert}/disciplines', [Web\IndexController::class, 'index'])->name('experts.disciplines.index');
Route::get('/experts/{expert}/disciplines/{discipline}', [Web\IndexController::class, 'index'])->name('experts.disciplines.show');
Route::get('/experts/{expert}/disciplines/{discipline}/calendar', [Web\IndexController::class, 'index'])->name('experts.disciplines.calendar');
Route::get('/experts/{expert}/formations', [Web\IndexController::class, 'index'])->name('experts.formations.index');
Route::get('/experts/{expert}/consultation', [Web\IndexController::class, 'index'])->name('experts.consultation');
Route::get('/formations', [Web\IndexController::class, 'index'])->name('formations.index');
Route::get('/formations/{formation}', [Web\IndexController::class, 'index'])->name('formations.view');
Route::get('/calendar', [Web\IndexController::class, 'index'])->name('calendar');
Route::get('/disciplines', [Web\IndexController::class, 'index'])->name('disciplines.index');
Route::get('/cours/disciplines', [Web\IndexController::class, 'index'])->name('cours.disciplines.index');
Route::get('/disciplines/{discipline}', [Web\IndexController::class, 'index'])->name('disciplines.view');
Route::get('/disciplines/{discipline}/formations', [Web\IndexController::class, 'index'])->name('disciplines.formations.index');
Route::get('/disciplines/{discipline}/experts', [Web\IndexController::class, 'index'])->name('disciplines.experts.index');
Route::get('/disciplines/{discipline}/experts/{expert}', [Web\IndexController::class, 'index'])->name('disciplines.experts.show');
Route::get('/disciplines/{discipline}/experts/{expert}/calendar', [Web\IndexController::class, 'index'])->name('disciplines.experts.calendar');
Route::get('/products', [Web\IndexController::class, 'index'])->name('products.index');


// Jitsi Meet Integration

Route::view("initiate/jitsi-meet/meeting", "jitsi.index");