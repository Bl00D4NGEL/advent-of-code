<?php

declare(strict_types=1);


namespace App\DayTwo;

use JetBrains\PhpStorm\Pure;

final class Position implements PositionInterface
{
    public function __construct(
        private int $depth,
        private int $horizontalPosition
    ) {
    }

    #[Pure] public function moveForward(int $amount): self
    {
        return new self($this->depth, $this->horizontalPosition + $amount);
    }

    #[Pure] public function moveDown(int $amount): self
    {
        return new self($this->depth + $amount, $this->horizontalPosition);
    }

    #[Pure] public function moveUp(int $amount): self
    {
        return new self($this->depth - $amount, $this->horizontalPosition);
    }

    #[Pure] public function depth(): int
    {
        return $this->depth;
    }

    #[Pure] public function horizontalPosition(): int
    {
        return $this->horizontalPosition;
    }
}
