<?php

namespace App\Http\Controllers;

use App\Actions\Battleships\CreateAttackAction;
use App\Actions\Battleships\CreateBattleshipLayout;
use App\Actions\Battleships\CreateDefenceAction;
use Illuminate\View\View;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class BattleshipController extends Controller
{
    public function __construct(
        protected CreateBattleshipLayout $createBattleshipLayout,
        protected CreateAttackAction $createAttackAction,
        protected CreateDefenceAction $createDefenceAction,
        protected DetermineUsersTurn $determineUsersTurn,
    ) {
    }

    public function newGameBattleship(HtmxRequest $request): View
    {
        $gameState = $this->createBattleshipLayout->execute();

        $turn = $this->determineUsersTurn->execute();

        return view('battleship-layout', ['map' => $gameState, 'your_turn' => $turn]);
    }

    public function attackBattleship(HtmxRequest $request)
    {
        $map = $this->createAttackAction->execute($request->getTriggerId());

        return view('battleship-layout', ['map' => $map]);
    }

    public function defendBattleship(HtmxRequest $request)
    {
        $map = $this->createDefenceAction->execute();

        return view('battleship-layout', ['map' => $map]);
    }
}
