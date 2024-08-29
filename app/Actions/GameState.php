<?php

namespace App\Actions;

use App\Models\Player;

abstract class GameState
{
    protected function newGame(Player $player): array
    {
        return [
            'round' => 0,
            'turn' => $player->id,
        ];
    }

    protected function boardLayoutBattleShip(): array
    {
        $index = 0;
        $map = [];
        $horizontal_range = range('A', 'J');
        $vertical_range = range(0, 10);

        foreach ($vertical_range as $key => $value) {
            $index++;
            if ($value === 0) {
                $map[$index]['value'] = '';
                $map[$index]['options'] = [];
            } elseif ($value !== 0) {
                $map[$index]['value'] = $value;
                $map[$index]['options'] = [];
            } else {
                $map[$index]['value'] = '';
                $map[$index]['options'] = [
                    'hover:bg-blue-300',
                ];
            }

            foreach ($horizontal_range as $letter) {
                $index++;
                if ($letter === 0) {
                    $map[$index]['value'] = '';
                    $map[$index]['options'] = [];
                } elseif ($value === 0) {
                    $map[$index]['value'] = $letter;
                    $map[$index]['options'] = [];
                } else {
                    $map[$index]['value'] = '';
                    $map[$index]['options'] = [
                        'hover:bg-blue-300',
                    ];
                }
            }
        }

        $map = $this->placeShips($map);

        return $map;
    }

    protected function placeShips($map): array
    {
        $gridWidth = 11;
        $gridHeight = 11;

        foreach ($this->ships() as $key => $value) {
            while (true) {
                $isVertical = rand(0, 1);

                if ($isVertical) {
                    $x = rand(1, $gridWidth - 1);
                    $y = rand(1, $gridHeight - $value);
                } else {
                    $x = rand(1, $gridWidth - $value);
                    $y = rand(1, $gridHeight - 1);
                }

                $allEmpty = true;
                for ($i = 0; $i < $value; $i++) {
                    $index = ($y + ($isVertical ? $i : 0)) * $gridWidth + ($x + ($isVertical ? 0 : $i));
                    if ($map[$index]['value'] !== '') {
                        $allEmpty = false;
                        break;
                    }
                }

                if ($allEmpty) {
                    for ($i = 0; $i < $value; $i++) {
                        $index = ($y + ($isVertical ? $i : 0)) * $gridWidth + ($x + ($isVertical ? 0 : $i));
                        $map[$index]['value'] = $key;
                    }
                    break;
                }
            }
        }

        return $map;
    }

    protected function ships(): array
    {
        return [
            'AC' => 5,
            'BS' => 4,
            'CR' => 3,
            'SU' => 3,
            'DE' => 2,
        ];
    }
}
