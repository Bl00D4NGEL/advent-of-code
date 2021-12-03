<?php

declare(strict_types=1);


namespace App\DayTwo;

use JetBrains\PhpStorm\Pure;

final class PositionWithAim implements PositionInterface
{
    public function __construct(
        private int $aim,
        private Position $position
    ) {
    }

    #[Pure] public function moveForward(int $amount): self
    {
        return new self(
            $this->aim,
            new Position(
                $this->position->depth() + $amount * $this->aim,
                $this->position->horizontalPosition() + $amount
            )
        );
    }

    #[Pure] public function moveDown(int $amount): self
    {
        return new self($this->aim + $amount, $this->position);
    }

    #[Pure] public function moveUp(int $amount): self
    {
        return new self($this->aim - $amount, $this->position);
    }

    #[Pure] public function depth(): int
    {
        return $this->position->depth();
    }

    #[Pure] public function horizontalPosition(): int
    {
        return $this->position->horizontalPosition();
    }
}
