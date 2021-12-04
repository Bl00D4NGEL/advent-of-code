<?php

declare(strict_types=1);

namespace App\DayFour\Bingo;

use InvalidArgumentException;

final class FieldCollection
{
    public function __construct(private array $fieldsCollection = [])
    {
    }

    public function generateFieldCollection(int $min, int $max): void
    {
        if ($min < 0) {
            throw new InvalidArgumentException('Lowest number to draw must not be below 0');
        }
        // We are using an array of fields to re-use the references to simplify logic down the line
        // Note: This is usually bad practice and shouldn't be this way
        for ($i = $min; $i <= $max; $i++) {
            $this->fieldsCollection[$i] = new Field($i);
        }
    }

    public function getField(int $index): Field
    {
        if (array_key_exists($index, $this->fieldsCollection)) {
            return $this->fieldsCollection[$index];
        }

        throw new InvalidArgumentException(sprintf('Index %s does not exist in collection.', $index));
    }
}