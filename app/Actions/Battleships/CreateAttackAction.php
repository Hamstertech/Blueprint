<?php

namespace App\Actions\Battleships;

use App\Actions\GameState;
use App\Enums\GameTypeEnum;
use App\Models\Game;
use App\Models\Player;

class CreateAttackAction extends GameState
{
    public function execute(string $fieldId): array
    {
        /** @var Player $player */
        $player = Player::firstOrCreate([
            'session_id' => session()->getId(),
        ]);
        $game = $player->runningGame(GameTypeEnum::BATTLESHIP);
        $opponent_id = $game->players()->wherePivot('player_id', '!=', $player->id)->first()->id;

        $gameState = $game->game_state;
        $cleanFieldId = ltrim($fieldId, 'A');
        if (in_array($gameState['board'][$opponent_id][$cleanFieldId]['value'], array_keys(parent::ships()))) {
            $gameState['board'][$opponent_id][$cleanFieldId]['value'] = 'O';
            // $gameState['turn'] = $opponent_id;
            $game->game_state = $gameState;
            $game->save();
        } elseif (in_array($gameState['board'][$opponent_id][$cleanFieldId]['value'], [''])) {
            $gameState['board'][$opponent_id][$cleanFieldId]['value'] = 'X';
            // $gameState['turn'] = $opponent_id;
            $game->game_state = $gameState;
            $game->save();
        }

        return $game->fresh()->game_state;
    }
}
