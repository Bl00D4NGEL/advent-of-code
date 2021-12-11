<?php

declare(strict_types=1);

namespace App\DaySix;

final class DaySix
{
    public function simulate(): int
    {
        $daysToSimulate = 80;
        $input = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $state = explode(',', $input);
        for ($i = 0; $i < $daysToSimulate; $i++) {
            $newFish = [];
            foreach ($state as &$value) {
                if ($value === 0) {
                    $value = 6;
                    $newFish[] = 8;
                } else {
                    $value--;
                }
            }
            $state = [
                ...$state,
                ...$newFish,
            ];
        }
        return count($state);
    }
}