<?php

declare(strict_types=1);

namespace App\DayFour\Bingo;

final class BoardGenerator
{
    public function __construct(
        private FieldCollection $fieldCollection
    ) {
    }

    /**
     * @param string[] $lines
     */
    public function generate(array $lines): Board
    {
        $rows = [];
        foreach ($lines as $line) {
            $line = trim($line);
            $numbers = preg_split('/\s+/', $line);
            $rows[] = array_map(
                fn (string $number): Field => $this->fieldCollection->getField((int)$number), $numbers
            );
        }

        return new Board($rows);
    }
}