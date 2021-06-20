<?php

use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhoneNumberController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('phone-numbers', PhoneNumberController::class)->middleware(['auth']);
Route::get('phone-numbers/{phonenumber}/share', [PhoneNumberController::class, 'share'])
    ->name('phone-numbers.share')->middleware(['auth']);
Route::patch('phone-numbers/{phonenumber}/makeShare', [PhoneNumberController::class, 'makeShare'])
    ->name('phone-numbers.makeShare')->middleware(['auth']);

Route::resource('photos', PhotoController::class);

require __DIR__.'/auth.php';
