<?php

namespace App\Http\Controllers;

use App\Actions\Battleships\ConnectBattleshipPlayers;
use App\Actions\Battleships\CreateAttackAction;
use App\Actions\Battleships\CreateBattleshipLayout;
use App\Actions\Battleships\DetermineUserTurn;
use App\Actions\Battleships\HideMapAction;
use App\Models\Game;
use Illuminate\View\View;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class BattleshipController extends Controller
{
    public function __construct(
        protected ConnectBattleshipPlayers $connectBattleshipPlayers,
        protected CreateBattleshipLayout $createBattleshipLayout,
        protected CreateAttackAction $createAttackAction,
        protected DetermineUserTurn $determineUsersTurn,
        protected HideMapAction $hideMapAction,
    ) {
    }

    public function newGameBattleship(HtmxRequest $request): View
    {
        $game = $this->createBattleshipLayout->execute();
        $turn = $this->determineUsersTurn->execute($game);
        $cleanedMap = $this->hideMapAction->execute($game);

        return view('battleship-layout', ['map' => $cleanedMap, 'your_turn' => $turn]);
    }

    public function attackBattleship(HtmxRequest $request): View
    {
        $game = $this->createAttackAction->execute($request->getTriggerId());
        $turn = $this->determineUsersTurn->execute($game);
        $cleanedMap = $this->hideMapAction->execute($game);

        return view('battleship-layout', ['map' => $cleanedMap, 'your_turn' => $turn]);
    }

    public function connectBattleshipPlayers(HtmxRequest $request): View
    {
        $game = $this->connectBattleshipPlayers->execute();
        if ($game instanceof Game) {
            $turn = $this->determineUsersTurn->execute($game);
            $cleanedMap = $this->hideMapAction->execute($game);
        }

        return view('battleship-layout', ['map' => $cleanedMap ?? $game, 'your_turn' => $turn ?? null]);
    }
}
