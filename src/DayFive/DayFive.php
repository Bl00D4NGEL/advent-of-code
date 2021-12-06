<?php

declare(strict_types=1);

namespace App\DayFive;

use JetBrains\PhpStorm\Pure;

final class DayFive
{
    public function getOverlapCount(): int
    {
        $input = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $lines = explode("\n", $input);
        $lines = array_filter($lines);
        $grid = new Grid();
        foreach ($lines as $line) {
            $parsedLine = $this->createLine($line);
            if (!$parsedLine->isValid()) {
                continue;
            }
            $grid->addPoints($parsedLine->getPathPoints());
        }

        return $grid->getOverLappingPointsCount();
    }

    #[Pure] private function createLine(string $line): Line
    {
        [$first, $second] = explode(' -> ', $line);
        $pointA = $this->createPoint($first);
        $pointB = $this->createPoint($second);
        return new Line($pointA, $pointB);
    }

    #[Pure] private function createPoint(string $coordinateString): Point
    {
        $coordinates = explode(',', $coordinateString);
        return new Point((int)$coordinates[0], (int)$coordinates[1]);
    }
}