<?php

declare(strict_types=1);


namespace App\DayTwo;

final class Position
{
    public function __construct(
        public int $depth,
        public int $horizontalPosition
    ) {
    }

    public function moveForward(int $amount): self
    {
        return new self($this->depth, $this->horizontalPosition + $amount);
    }

    public function moveDown(int $amount): self
    {
        return new self($this->depth + $amount, $this->horizontalPosition);
    }

    public function moveUp(int $amount): self
    {
        return new self($this->depth - $amount, $this->horizontalPosition);
    }
}
