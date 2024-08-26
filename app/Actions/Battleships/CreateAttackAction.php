<?php

namespace App\Actions\Battleships;

use App\Actions\GameState;

class CreateAttackAction extends GameState
{
    public function execute(): array
    {
        $map = $this->gameState();

        return $map;
    }

    protected function gameState(): array
    {
        return [
            ...parent::newGame(),
            'board' => [
                0 => parent::boardLayoutBattleShip(),
                1 => parent::boardLayoutBattleShip(),
            ],
        ];
    }
}
