<?php

namespace App\Actions\Battleships;

use Illuminate\Support\Facades\Cache;

class CreateDefenceAction
{
    public function execute(): array
    {
        $map = [];
        $horizontal_range = range('A', 'J');
        $vertical_range = range(0, 10);

        foreach ($vertical_range as $value) {
            if ($value !== 0) {
                $map[] = $value;
            } else {
                $map[] = '';
            }

            foreach ($horizontal_range as $letter) {
                if ($value === 0) {
                    $map[] = $letter;
                } else {
                    $map[] = '';
                }
            }
        }

        if (empty(array_intersect(['AC', 'BS', 'CR', 'SU', 'DE'], $map))) {
            $map = $this->placeShips($map);
        }

        Cache::put('battleship_player'.session()->getId(), json_encode($map), 600);

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
                    if ($map[$index] !== '') {
                        $allEmpty = false;
                        break;
                    }
                }

                if ($allEmpty) {
                    for ($i = 0; $i < $value; $i++) {
                        $index = ($y + ($isVertical ? $i : 0)) * $gridWidth + ($x + ($isVertical ? 0 : $i));
                        $map[$index] = $key;
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
