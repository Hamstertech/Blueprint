<?php

namespace App\Actions\Battleships;

use App\Enums\GameTypeEnum;
use App\Models\Game;
use App\Models\Player;

class ConnectBattleshipPlayers
{
    public function __construct(
        protected CreateBattleshipLayout $createBattleshipLayout,
    ) {
    }

    public function execute(): Game|bool
    {
        /** @var Player $player1 */
        $player1 = Player::firstOrCreate([
            'session_id' => session()->getId(),
        ]);

        if ($runningGame = $player1->runningGame(GameTypeEnum::BATTLESHIP)) {
            $map = $runningGame;
        } else {
            /** @var Player $player2 */
            $player2 = Player::where('searching', GameTypeEnum::BATTLESHIP->value)->where('id', '!=', $player1->id)->first();
            $player1->searching = GameTypeEnum::BATTLESHIP->value;
            $player1->save();

            if (isset($player2)) {
                $map = $this->createBattleshipLayout->execute($player1, $player2, GameTypeEnum::BATTLESHIP);
            }
        }

        return $map ?? false;
    }
}
