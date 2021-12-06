<?php

declare(strict_types=1);

namespace App\DayFive;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

final class DiagonalLine
{
    public function __construct(
        #[Immutable]
        public Point $pointA,
        #[Immutable]
        public Point $pointB,
    ) {
    }

    #[Pure] public function isValid(): bool
    {
        if ($this->isValidX()) {
            return true;
        }

        if ($this->isValidY()) {
            return true;
        }

        return $this->isValidDiagonal();
    }

    /**
     * @return Point[]
     */
    #[Pure] public function getPathPoints(): array
    {
        if ($this->isValidX()) {
            return $this->createYPoints();
        }
        if ($this->isValidY()) {
            return $this->createXPoints();
        }

        return $this->createDiagonalPoints();
    }

    private function isValidX(): bool
    {
        return $this->pointA->x === $this->pointB->x;
    }

    private function isValidY(): bool
    {
        return $this->pointA->y === $this->pointB->y;
    }

    /**
     * @return Point[]
     */
    #[Pure] private function createYPoints(): array
    {
        $paths = [];
        $start = min([$this->pointA->y, $this->pointB->y]);
        $end = max([$this->pointA->y, $this->pointB->y]);
        for ($i = $start; $i <= $end; $i++) {
            $paths[] = new Point($this->pointA->x, $i);
        }
        return $paths;
    }

    /**
     * @return Point[]
     */
    #[Pure] private function createXPoints(): array
    {
        $paths = [];
        $start = min([$this->pointA->x, $this->pointB->x]);
        $end = max([$this->pointA->x, $this->pointB->x]);
        for ($i = $start; $i <= $end; $i++) {
            $paths[] = new Point($i, $this->pointA->y);
        }

        return $paths;
    }

    private function isValidDiagonal(): bool
    {
        $diffX = abs($this->pointA->x - $this->pointB->x);
        $diffY = abs($this->pointA->y - $this->pointB->y);
        return $diffX === $diffY;
    }

    /**
     * @return Point[]
     */
    #[Pure] private function createDiagonalPoints(): array
    {
        $points = [];
        $diff = abs($this->pointA->x - $this->pointB->x);
        for ($i = 0; $i <= $diff; $i++) {
            $points[] = new Point($this->calculateNewX($i), $this->calculateNewY($i));
        }
        return $points;
    }

    private function calculateNewX(int $steps): int
    {
        if ($this->pointA->x - $this->pointB->x > 0) {
            return $this->pointA->x - $steps;
        }

        return $this->pointA->x + $steps;
    }

    private function calculateNewY(int $steps): int
    {
        if ($this->pointA->y - $this->pointB->y > 0) {
            return $this->pointA->y - $steps;
        }

        return $this->pointA->y + $steps;
    }
}