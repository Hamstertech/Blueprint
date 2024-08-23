<?php

namespace App\Http\Controllers;

use App\Actions\Battleships\CreateAttackAction;
use App\Actions\Battleships\CreateDefenceAction;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class BattleshipController extends Controller
{
    public function __construct(
        protected CreateAttackAction $createAttackAction,
        protected CreateDefenceAction $createDefenceAction,
    ) {
    }

    public function attackBattleship(HtmxRequest $request)
    {
        $map = $this->createAttackAction->execute();

        return view('battleship-attack', ['attack_map' => $map]);
    }

    public function defendBattleship(HtmxRequest $request)
    {
        // dd(session()->getId());
        $map = $this->createDefenceAction->execute();

        return view('battleship-defend', ['defence_map' => $map]);
    }
}
