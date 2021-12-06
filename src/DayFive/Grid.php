<?php

declare(strict_types=1);

namespace App\DayFive;

final class Grid
{
    /** @var Point[] */
    private array $points = [];

    public function addPoints(array $points): void
    {
        foreach ($points as $point) {
            $this->points[] = $point;
        }
    }

    public function getOverLappingPointsCount(int $overLaps = 2): int
    {
        $pointMap = [];
        foreach ($this->points as $point) {
            $mapKey = $point->x . ',' . $point->y;
            $pointMap[$mapKey] = ($pointMap[$mapKey] ?? 0) + 1;
        }

        $out = array_filter($pointMap, static fn(int $value): bool => $value >= $overLaps);
        return count($out);
    }
}