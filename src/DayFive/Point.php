<?php

declare(strict_types=1);

namespace App\DayFive;

use JetBrains\PhpStorm\Immutable;

final class Point
{
    public function __construct(
        #[Immutable]
        public int $x,
        #[Immutable]
        public int $y
    ) {
    }
}