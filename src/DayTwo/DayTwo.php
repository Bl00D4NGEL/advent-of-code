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

        $position = $this->processCommands(new Position(0,0), $commands);

        return $position->horizontalPosition() * $position->depth();
    }

    public function getResultWithAim(): int
    {
        $numbersInput = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $commands = explode("\n", $numbersInput);
        $commands = array_map('trim', $commands);
        $position = $this->processCommands(new PositionWithAim(0, new Position(0, 0)), $commands);

        return $position->horizontalPosition() * $position->depth();
    }

    /**
     * @param string[] $commands
     */
    private function processCommands(PositionInterface $startingPosition, array $commands): PositionInterface
    {
        foreach ($commands as $command) {
            if (preg_match('/forward (\d+)/', $command, $matches)) {
                $startingPosition = $startingPosition->moveForward((int)$matches[1]);
            }
            if (preg_match('/up (\d+)/', $command, $matches)) {
                $startingPosition = $startingPosition->moveUp((int)$matches[1]);
            }
            if (preg_match('/down (\d+)/', $command, $matches)) {
                $startingPosition = $startingPosition->moveDown((int)$matches[1]);
            }
        }
        return $startingPosition;
    }
}
