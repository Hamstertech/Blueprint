<?php

namespace App\Actions\Battleships;

class CreateAttackAction
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

        return $map;
    }
}
