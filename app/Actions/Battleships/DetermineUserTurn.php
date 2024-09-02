<?php

namespace App\Actions\Battleships;

use App\Actions\GameState;
use App\Models\Game;

class DetermineUserTurn extends GameState
{
    public function execute(Game $game): bool
    {
        $players = $game->players;
        if ($players->where('session_id', session()->getId())->first()->id === $game->game_state['turn']) {
            $turn = true;
        } else {
            $turn = false;
        }

        return $turn;
    }
}
