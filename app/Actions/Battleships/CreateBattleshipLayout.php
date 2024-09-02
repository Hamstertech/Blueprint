<?php

namespace App\Actions\Battleships;

use App\Actions\GameState;
use App\Enums\GameTypeEnum;
use App\Models\Game;
use App\Models\Player;

class CreateBattleshipLayout extends GameState
{
    public function execute(Player $player1, Player $player2, GameTypeEnum $gameType): Game
    {
        $map = $this->initialGameState($player1, $player2);
        $newGame = new Game;
        $newGame->game_type = GameTypeEnum::BATTLESHIP;
        $newGame->game_state = $map;
        $newGame->save();

        $newGame->linkPlayers($player1, $player2);

        $player1->searching = null;
        $player1->save();
        $player2->searching = null;
        $player2->save();

        return $newGame->fresh();
    }

    protected function initialGameState(Player $player1, Player $player2): array
    {
        // TODO: Make a "continued game state" to make sure you can hide opponent information when sending information
        return [
            ...parent::newGame($player1),
            'board' => [
                $player1->id => parent::boardLayoutBattleShip(),
                $player2->id => parent::boardLayoutBattleShip(),
            ],
        ];
    }
}
