<?php

namespace App\Actions\Battleships;

class CreateAttackAction
{
    public function execute(): array
    {
        $index = 1;
        $map = [];

        $horizontal_range = range('A', 'J');
        $vertical_range = range(1, 10);
        dd($vertical_range);

        // for ($i=0; $i <= 120; $i++) {
        //     if ($i === 0) {
        //         $map[$i] = [
        //             'value' => '',
        //             'options' => '',
        //         ];
        //     } elseif (in_array($i, range(1, 10))) {
        //         $map[$i] = [
        //             'value' => $horizontal_range[$i-1],
        //             'options' => '',
        //         ];
        //     } elseif (($i % 11) === 0) {
        //         $map[$i] = [
        //             'value' => $vertical_range[$i % 10],
        //             'options' => '',
        //         ];
        //     } else {
        //         $map[$i] = [
        //             'value' => '',
        //             'options' => 'hover:bg-blue-300',
        //         ];
        //     }
        // }

        foreach ($vertical_range as $key => $value) {
            if (($key % 10) === 0) {
                $map[$index]['value'] = $value;
                $map[$index]['options'] = '';
            } else {
                $map[$index]['value'] = '';
                $map[$index]['options'] = 'hover:bg-blue-300';
            }

            foreach ($horizontal_range as $letter) {
                if ($value === 1) {
                    $map[$index]['value'] = $letter;
                    $map[$index]['options'] = '';
                } else {
                    $map[$index]['value'] = '';
                    $map[$index]['options'] = 'hover:bg-blue-300';
                }
                $index++;
            }
        }

        return $map;
    }
}
