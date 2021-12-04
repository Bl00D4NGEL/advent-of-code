<?php

declare(strict_types=1);


namespace App\DayThree;

use Exception;
use JetBrains\PhpStorm\Pure;

final class DayThree
{
    public function getPowerConsumption(): int
    {
        $reportLines = $this->getInput();
        // We assume that the first element has the length as every other line
        $lineLength = strlen($reportLines[0]);
        $gammaBits = [];
        for ($i = 0; $i < $lineLength; $i++) {
            $valuesAtIndex = array_map(static fn (string $reportLine): int => (int)$reportLine[$i], $reportLines);
            $gammaBits[] = $this->getMostCommonNumber($valuesAtIndex);
        }

        $gamma = bindec(implode('', $gammaBits));
        // e.g. line length = 2 therefore this is 4096 - 1 - $gamma
        // This works because we need to invert the binary string => 10101 (21) turns into 01010 (10)
        // Which shows that it's 2 to the power of the string length (5) => 2^5 = 32 minutes 1 (31)
        // Now it's a simple formula like this:
        // Epsilon = 31 - Gamma
        $epsilon = 2 ** $lineLength - 1 - $gamma;
        return $gamma * $epsilon;
    }

    public function getRating(): int
    {
        $reportLines = $this->getInput();

        $oxygenRating = $this->determineRating($reportLines, [$this, 'getMostCommonNumber']);
        $scrubberRating = $this->determineRating($reportLines, [$this, 'getLeastCommonNumber']);

        return $oxygenRating * $scrubberRating;
    }

    /**
     * @param string[] $reportLines
     * @param callable $numberDeterminer
     * @return int
     * @throws Exception
     */
    private function determineRating(array $reportLines, callable $numberDeterminer): int
    {
        // We assume that the first element has the length as every other line
        $lineLength = strlen($reportLines[0]);
        $rating = '';
        $modifiedReportLines = $reportLines;
        for ($i = 0; $i < $lineLength; $i++) {
            $valuesAtIndex = array_map(static fn (string $reportLine): int => (int)$reportLine[$i], $modifiedReportLines);
            $rating .= $numberDeterminer($valuesAtIndex);
            $modifiedReportLines = array_filter($modifiedReportLines, static fn(string $reportLine): bool => str_starts_with($reportLine, $rating));
            if ($this->isRatingDetermined($modifiedReportLines)) {
                return $this->getFinalRating($modifiedReportLines);
            }
        }

        throw new Exception('Could not determine rating');
    }

    /**
     * @param int[] $valuesAtIndex
     */
    #[Pure] private function getMostCommonNumber(array $valuesAtIndex): int
    {
        // Since there will only be 1s and 0s we can assume that if the sum of the array is smaller than the total
        // report line count divided by 2 then the majority is 0s, otherwise it's 1s
        // e.g. 1000 lines => 500 is half of it, if the sum is 450 then there are 550 0s
        $onesCount = array_sum($valuesAtIndex);
        return count($valuesAtIndex) / 2 > $onesCount ? 0 : 1;
    }

    /**
     * @param int[] $valuesAtIndex
     */
    #[Pure] private function getLeastCommonNumber(array $valuesAtIndex): int
    {
        return $this->getMostCommonNumber($valuesAtIndex) === 1 ? 0 : 1;
    }

    /**
     * @param string[] $modifiedReportLines
     */
    private function isRatingDetermined(array $modifiedReportLines): bool
    {
        return count($modifiedReportLines) === 1;
    }

    /**
     * @param string[] $modifiedReportLines
     */
    private function getFinalRating(array $modifiedReportLines): int
    {
        return bindec(current($modifiedReportLines));
    }

    /**
     * @return string[]
     */
    private function getInput(): array
    {
        $numbersInput = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $reportLines = explode("\n", $numbersInput);
        $reportLines = array_map('trim', $reportLines);
        return array_filter($reportLines);
    }
}
