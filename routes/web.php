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

Route::get('/game/battleship/connect', [BattleshipController::class, 'connectBattleshipPlayers'])->name('game.battleship.connect');
Route::get('/game/battleship/attack', [BattleshipController::class, 'attackBattleship'])->name('game.battleship.attack');
Route::get('/game/battleship/generate', [BattleshipController::class, 'newGameBattleship'])->name('game.battleship.generate');
