<?php

namespace App\Http\Controllers;

use App\Actions\Battleships\CreateAttackAction;
use App\Actions\Battleships\CreateBattleshipLayout;
use App\Actions\Battleships\CreateDefenceAction;
use App\Actions\Battleships\DetermineUserTurn;
use Illuminate\View\View;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class BattleshipController extends Controller
{
    public function __construct(
        protected CreateBattleshipLayout $createBattleshipLayout,
        protected CreateAttackAction $createAttackAction,
        protected CreateDefenceAction $createDefenceAction,
        protected DetermineUserTurn $determineUsersTurn,
    ) {
    }

    public function newGameBattleship(HtmxRequest $request): View
    {
        $game = $this->createBattleshipLayout->execute();
        $turn = $this->determineUsersTurn->execute($game);

        return view('battleship-layout', ['map' => $game->game_state, 'your_turn' => $turn]);
    }

    public function attackBattleship(HtmxRequest $request): View
    {
        $game = $this->createAttackAction->execute($request->getTriggerId());
        $turn = $this->determineUsersTurn->execute($game);

        return view('battleship-layout', ['map' => $game->game_state, 'your_turn' => $turn]);
    }

    public function defendBattleship(HtmxRequest $request): View
    {
        $map = $this->createDefenceAction->execute();

        return view('battleship-layout', ['map' => $map]);
    }
}
