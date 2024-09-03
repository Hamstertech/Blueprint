<?php

namespace App\Actions\Battleships;

use App\Actions\GameState;
use App\Models\Game;
use App\Models\Player;

class HideMapAction extends GameState
{
    public function execute(Game $game): array
    {
        $map = $game->game_state;
        $player = Player::firstOrCreate([
            'session_id' => session()->getId(),
        ]);
        $opponent_id = $game->players()->wherePivot('player_id', '!=', $player->id)->first()->id;
        $map['board'][$opponent_id] = $this->cleanMap($map['board'][$opponent_id]);
        $personal_board = $map['board'][$player->id];
        unset($map['board'][$player->id]);
        $map['board'][$player->id] = $personal_board;

        return $map;
    }

    protected function cleanMap(array $map): array
    {
        foreach ($map as $key => $value) {
            if (in_array($value['value'], array_keys(parent::ships()))) {
                $map[$key]['value'] = '';
            }
        }

        return $map;
    }
}
