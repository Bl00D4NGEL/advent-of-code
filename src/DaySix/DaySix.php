<?php

declare(strict_types=1);

namespace App\DaySix;

final class DaySix
{
    public function simulate(int $daysToSimulate): int
    {
        $counter = array_fill(0, 9, 0);

        $input = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $state = explode(',', $input);

        foreach ($state as $value) {
            $counter[$value]++;
        }

        for ($i = 0; $i < $daysToSimulate; $i++) {
            $dayZero = $counter[0];
            for ($j = 1; $j < 9; $j++) {
                $counter[$j - 1] = $counter[$j];
            }
            $counter[6] += $dayZero;
            $counter[8] = $dayZero;
        }

        return array_sum($counter);
    }
}