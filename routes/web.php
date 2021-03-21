<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MissionController;
use App\Models\Mission;

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
    return view('landing');
})->name('home');

Route::get('/mission', [MissionController::class, 'start'])->name('mission.new');
Route::get('/mission/{mission}', [MissionController::class, 'view'])->name('mission.view');

Route::fallback(function () {
    return redirect('/');
});