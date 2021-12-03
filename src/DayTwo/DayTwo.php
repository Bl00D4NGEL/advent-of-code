<?php

declare(strict_types=1);

namespace App\DayTwo;

final class DayTwo
{
    public function getResult(): int
    {
        $numbersInput = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $commands = explode("\n", $numbersInput);
        $commands = array_map('trim', $commands);
        $position = new Position(0,0);
        foreach ($commands as $command) {
            if (preg_match('/forward (\d+)/', $command, $matches)) {
                $position = $position->moveForward((int)$matches[1]);
            }
            if (preg_match('/up (\d+)/', $command, $matches)) {
                $position = $position->moveUp((int)$matches[1]);
            }
            if (preg_match('/down (\d+)/', $command, $matches)) {
                $position = $position->moveDown((int)$matches[1]);
            }
        }

        return $position->horizontalPosition * $position->depth;
    }
}
