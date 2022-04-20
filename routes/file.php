<?php

use App\Http\Controllers\Web;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| File Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/u/picto-{user}.jpg', [Web\File\UserController::class, 'picto'])->name('image.users.picto');
Route::get('/u/image-{user}.jpg', [Web\File\UserController::class, 'image'])->name('image.users.image');
Route::get('/f/picto-{formation}.jpg', [Web\File\FormationController::class, 'picto'])->name('image.formations.picto');
Route::get('/f/image-{formation}.jpg', [Web\File\FormationController::class, 'image'])->name('image.formations.image');
Route::get('/d/picto-{discipline}.jpg', [Web\File\DisciplineController::class, 'picto'])->name('image.disciplines.picto');
Route::get('/d/image-{discipline}.jpg', [Web\File\DisciplineController::class, 'image'])->name('image.disciplines.image');
