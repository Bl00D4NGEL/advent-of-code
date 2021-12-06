<?php

declare(strict_types=1);

namespace App\DayFive;

use JetBrains\PhpStorm\Pure;

final class GridFactory
{
    /**
     * @param class-string $lineType
     * @param string[] $inputLines
     */
    public function createGridWithLineType(string $lineType, array $inputLines): Grid
    {
        $grid = new Grid();
        foreach ($inputLines as $inputLine) {
            $line = $this->createDynamicLine($lineType, $inputLine);
            if (!$line->isValid()) {
                continue;
            }

            $grid->addPoints($line->getPathPoints());
        }

        return $grid;
    }

    /**
     * @param class-string $lineType
     * @param string[] $inputLine
     */
    private function createDynamicLine(string $lineType, mixed $inputLine): DiagonalLine|Line
    {
        if ($lineType === DiagonalLine::class) {
            $line = $this->createDiagonalLine($inputLine);
        } elseif ($lineType === Line::class) {
            $line = $this->createLine($inputLine);
        } else {
            throw new \InvalidArgumentException('unsupported line type given: ' . $lineType);
        }
        return $line;
    }

    #[Pure] private function createLine(string $line): Line
    {
        [$first, $second] = explode(' -> ', $line);
        $pointA = $this->createPoint($first);
        $pointB = $this->createPoint($second);
        return new Line($pointA, $pointB);
    }

    #[Pure] private function createDiagonalLine(string $line): DiagonalLine
    {
        [$first, $second] = explode(' -> ', $line);
        $pointA = $this->createPoint($first);
        $pointB = $this->createPoint($second);
        return new DiagonalLine($pointA, $pointB);
    }

    #[Pure] private function createPoint(string $coordinateString): Point
    {
        $coordinates = explode(',', $coordinateString);
        return new Point((int)$coordinates[0], (int)$coordinates[1]);
    }

}