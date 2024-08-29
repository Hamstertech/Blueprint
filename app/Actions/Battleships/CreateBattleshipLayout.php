<?php

namespace App\Actions\Battleships;

use App\Actions\GameState;
use App\Enums\GameTypeEnum;
use App\Models\Game;
use App\Models\Player;

class CreateBattleshipLayout extends GameState
{
    public function execute(): array
    {
        /** @var Player $player1 */
        $player1 = Player::firstOrCreate([
            'session_id' => session()->getId(),
        ]);
        /** @var Player $player2 */
        $player2 = Player::firstOrCreate([
            'session_id' => 'tester',
        ]);
        $games = $player1->sharedGamesWith($player2, GameTypeEnum::BATTLESHIP);
        if (!empty($games)) {
            $map = $games->latest()->first()->game_state;
        } else {
            $map = $this->gameState($player1, $player2);
            $newGame = new Game;
            $newGame->game_type = GameTypeEnum::BATTLESHIP;
            $newGame->game_state = $map;
            $newGame->save();

            $newGame->linkPlayers($player1, $player2);
        }

        return $map;
    }

    protected function gameState(Player $player1, Player $player2): array
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
