<?php

use App\Http\Controllers\BattleshipController;
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

Route::get('/', function () {
    return view('app');
    // return ['Laravel' => app()->version(), 'PHP' => phpversion()];
});

Route::get('/information', function () {
    return '<p>Hello world! '.random_int(0, 10000).' </p>';
})->name('information');

Route::get('/battleship/attack', [BattleshipController::class, 'attackBattleship'])->name('battleship.attack');
Route::get('/battleship/defend', [BattleshipController::class, 'defendBattleship'])->name('battleship.defend');
