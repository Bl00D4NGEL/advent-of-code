<?php

declare(strict_types=1);

namespace App\DayFive;

final class DayFive
{
    private GridFactory $gridFactory;

    public function __construct(GridFactory $gridFactory = null)
    {
        $this->gridFactory = $gridFactory ?? new GridFactory();
    }

    public function getOverlapCount(): int
    {
        $grid = $this->gridFactory->createGridWithLineType(Line::class, $this->parseInput());

        return $grid->getOverLappingPointsCount();
    }

    public function getDiagonalOverlapCount(): int
    {
        $grid = $this->gridFactory->createGridWithLineType(DiagonalLine::class, $this->parseInput());

        return $grid->getOverLappingPointsCount();
    }

    private function parseInput(): array
    {
        $input = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $lines = explode("\n", $input);
        return array_filter($lines);
    }
}