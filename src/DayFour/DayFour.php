<?php

declare(strict_types=1);

namespace App\DayFour;

use App\DayFour\Bingo\Board;
use App\DayFour\Bingo\BoardGenerator;
use App\DayFour\Bingo\Field;
use App\DayFour\Bingo\FieldCollection;
use Exception;

final class DayFour
{
    private FieldCollection $fieldsCollection;
    private BoardGenerator $boardGenerator;

    /** @var Board[] */
    private array $boards = [];

    /** @var int[] */
    private array $numbersToDraw = [];

    public function __construct()
    {
        $this->fieldsCollection = new FieldCollection();
        $this->boardGenerator = new BoardGenerator($this->fieldsCollection);
    }

    public function getResultForFirstBoardToWin(): int
    {
        $this->parseInput();

        foreach ($this->numbersToDraw as $numberToDraw) {
            $this->fieldsCollection->getField($numberToDraw)->draw();
            foreach ($this->boards as $board) {
                if ($board->isWon()) {
                    return $this->calculateBoardResult($board, $numberToDraw);
                }
            }
        }

        throw new Exception('Could not find a winning board with the draws given');
    }

    public function getResultForLastBoardToWin(): int
    {
        $this->parseInput();

        foreach ($this->numbersToDraw as $numberToDraw) {
            $this->fieldsCollection->getField($numberToDraw)->draw();

            if (count($this->boards) === 1) {
                $board = current($this->boards);
                if ($board->isWon()) {
                    return $this->calculateBoardResult($board, $numberToDraw);
                }
            }

            $this->boards = array_filter($this->boards, static fn (Board $board): bool => !$board->isWon());
        }

        throw new Exception('No board won');
    }

    private function parseInput(): void
    {
        // reset
        $this->fieldsCollection = new FieldCollection();
        $this->boardGenerator = new BoardGenerator($this->fieldsCollection);
        $this->numbersToDraw = [];
        $this->boards = [];

        $input = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $lines = explode("\n", $input);
        // First line are the numbers drawn
        $numbersDrawn = array_shift($lines);

        $this->generateNumbersToDraw($numbersDrawn);
        $this->generateFieldCollection();
        $this->generateBoards($lines);
    }

    private function generateNumbersToDraw(string $numbersDrawn): void
    {
        $parsedNumbersDrawn = explode(',', $numbersDrawn);
        $this->numbersToDraw = array_map(static fn (string $number): int => (int)$number, $parsedNumbersDrawn);
    }

    private function generateFieldCollection(): void
    {
        $lowestNumber = min($this->numbersToDraw);
        $highestNumber = max($this->numbersToDraw);
        $this->fieldsCollection->generateFieldCollection($lowestNumber, $highestNumber);
    }

    private function generateBoards(array $lines): void
    {
        for ($i = 0, $iMax = count($lines); $i < $iMax; $i += 6) {
            // Since the board is 5x5 and the first line is an empty line we take 5 lines
            $slicedLines = array_slice($lines, $i + 1, 5);
            $this->boards[] = $this->boardGenerator->generate($slicedLines);
        }
    }

    private function calculateBoardResult(Board $board, int $numberToDraw): int
    {
        $unmarkedFields = $board->getUnmarkedFields();
        $numbers = array_map(
            static fn (Field $field): int => $field->getNumber(), $unmarkedFields
        );
        $sum = (int)array_sum($numbers);
        return $sum * $numberToDraw;
    }
}