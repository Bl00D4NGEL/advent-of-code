<?php

declare(strict_types=1);

namespace App\DayFour\Bingo;

final class Field
{
    private bool $wasDrawn = false;

    public function __construct(private int $number)
    {
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function draw(): void
    {
        $this->wasDrawn = true;
    }

    public function hasBeenDrawn(): bool
    {
        return $this->wasDrawn;
    }
}