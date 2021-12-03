<?php

declare(strict_types=1);

namespace App\DayOne;

final class DayOne
{
    public function getIncrements(): int
    {
        $numbersInput = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $numbers = explode("\n", $numbersInput);
        $numbers = array_map(static fn (string $number): int => (int)$number, $numbers);

        return $this->calculateIncrements($numbers);
    }

    public function getGroupsIncrements(): int
    {
        $numbersInput = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $numbers = explode("\n", $numbersInput);
        $numbers = array_map(static fn (string $number): int => (int)$number, $numbers);

        return $this->calculateGroupIncrements($numbers);
    }

    /**
     * @param int[] $numbers
     */
    private function calculateIncrements(array $numbers): int
    {
        $prevNumber = null;
        $increments = 0;
        foreach ($numbers as $number) {
            if ($prevNumber === null) {
                $prevNumber = $number;
                continue;
            }
            if ($number > $prevNumber) {
                print "$number > $prevNumber\n";
                $increments++;
            }
            $prevNumber = $number;
        }
        return $increments;
    }

    /**
     * @param int[] $numbers
     */
    private function calculateGroupIncrements(array $numbers): int
    {
        $sums = [];
        for ($i = 0; $i < count($numbers); $i++) {
            $sums[] = array_sum(array_slice($numbers, $i, 3));
        }
        return $this->calculateIncrements($sums);
    }
}
