<?php

declare(strict_types=1);

namespace App\DayEight;

final class DayEight
{
    public function getOccurrences(): int
    {
        $input = file_get_contents(__DIR__ . '/Fixture/input.txt');

        $occurrences = 0;
        $lines = explode("\n", $input);
        foreach ($lines as $line) {
            [, $second] = explode(' | ', $line);
            $secondParts = explode(' ', $second);
            // We only want the digits that are 2, 3, 4 or 7 characters long
            // Which represent 1, 7, 4 and 8 respectively
            $filtered = array_filter(
                $secondParts,
                static fn (string $val): bool => in_array(strlen($val), [2, 3, 4, 7], true)
            );

            $occurrences += count($filtered);
        }

        return $occurrences;
    }
}