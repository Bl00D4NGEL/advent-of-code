<?php

declare(strict_types=1);

namespace App\DayFive;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

final class Line
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

        return $this->isValidY();
    }

    /**
     * @return Point[]
     */
    #[Pure] public function getPathPoints(): array
    {
        if ($this->isValidX()) {
            return $this->createYPoints();
        }

        return $this->createXPoints();
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
}