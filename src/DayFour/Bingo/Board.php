<?php

declare(strict_types=1);

namespace App\DayFour\Bingo;

use JetBrains\PhpStorm\Pure;

final class Board
{
    public function __construct(
        /** @var array<int, Field[]> $rows */
        private array $rows
    ) {
    }

    public function getUnmarkedFields(): array
    {
        $unmarkedFields = [];
        foreach ($this->rows as $row) {
            foreach ($row as $field) {
                if (!$field->hasBeenDrawn()) {
                    $unmarkedFields[] = $field;
                }
            }
        }
        return $unmarkedFields;
    }

    public function isWon(): bool
    {
        foreach ($this->rows as $row) {
            $isWon = $this->checkWin($row);
            if ($isWon) {
                return true;
            }
        }

        foreach ($this->buildColumns() as $column) {
            $isWon = $this->checkWin($column);
            if ($isWon) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Field[] $fields
     */
    #[Pure] private function checkWin(array $fields): bool
    {
        $isWon = true;
        foreach ($fields as $field) {
            $isWon = $field->hasBeenDrawn();
            if (!$isWon) {
                break;
            }
        }
        return $isWon;
    }

    /**
     * @return array<int, Field[]>
     */
    private function buildColumns(): array
    {
        $columns = [];
        for ($i = 0, $iMax = count($this->rows); $i < $iMax; $i++) {
            $columns[] = array_map(static fn (array $fields): Field => $fields[$i], $this->rows);
        }
        return $columns;
    }

    public function dump()
    {
        foreach ($this->rows as $row) {
            foreach ($row as $field) {
                print $field->getNumber() . ' ';
            }
            print PHP_EOL;
        }
    }
}