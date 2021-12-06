<?php

declare(strict_types=1);

namespace App\DayFive;

final class Formatter
{
    public function formatPathPoints(Line $line): void
    {
        $this->formatLine($line);
        foreach ($line->getPathPoints() as $pathPoint) {
            printf('%s, %s' . PHP_EOL, $pathPoint->x, $pathPoint->y);
        }
    }

    public function formatLine(Line $line): void
    {
        printf("%s, %s -> %s, %s\n", $line->pointA->x, $line->pointA->y, $line->pointB->x, $line->pointB->y);
    }
}