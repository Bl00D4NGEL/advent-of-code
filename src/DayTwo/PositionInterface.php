<?php

declare(strict_types=1);


namespace App\DayTwo;

use JetBrains\PhpStorm\Pure;

interface PositionInterface
{
    #[Pure] public function moveForward(int $amount): self;
    #[Pure] public function moveDown(int $amount): self;
    #[Pure] public function moveUp(int $amount): self;

    public function depth(): int;
    public function horizontalPosition(): int;
}
