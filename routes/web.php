<?php

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

Route::resource('phoneNumbers', PhoneNumberController::class);
Route::get('phoneNumbers/{phoneNumber}/share', [PhoneNumberController::class, 'share'])
    ->name('phoneNumbers.share')->middleware(['auth']);
Route::patch('phoneNumbers/{phoneNumber}/makeShare', [PhoneNumberController::class, 'makeShare'])
    ->name('phoneNumbers.makeShare')->middleware(['auth']);


require __DIR__.'/auth.php';
