<?php

declare(strict_types=1);


namespace App\DayThree;

final class DayThree
{
    public function getPowerConsumption(): int
    {
        $numbersInput = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $reportLines = explode("\n", $numbersInput);
        $reportLines = array_map('trim', $reportLines);
        $reportLines = array_filter($reportLines);
        // We assume that the first element has the length as every other line
        $lineLength = strlen($reportLines[0]);
        $gammaBits = [];
        for ($i = 0; $i < $lineLength; $i++) {
            $valuesAtIndex = array_map(static fn (string $reportLine): int => (int)$reportLine[$i], $reportLines);
            $gammaBits = [
                ...$gammaBits,
                $this->getMostCommonNumber($valuesAtIndex),
            ];
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
        $numbersInput = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $reportLines = explode("\n", $numbersInput);
        $reportLines = array_map('trim', $reportLines);
        $reportLines = array_filter($reportLines);
        // We assume that the first element has the length as every other line
        $lineLength = strlen($reportLines[0]);
        $oxygenRating = '';
        $modifiedReportLines = $reportLines;
        for ($i = 0; $i < $lineLength; $i++) {
            $valuesAtIndex = array_map(static fn (string $reportLine): int => (int)$reportLine[$i], $modifiedReportLines);
            $mostCommon = $this->getMostCommonNumber($valuesAtIndex);
            $oxygenRating .= $mostCommon;
            $modifiedReportLines = array_filter($modifiedReportLines, static fn(string $reportLine): bool => str_starts_with($reportLine, $oxygenRating));
            if (count($modifiedReportLines) === 1) {
                $oxygenRating = current($modifiedReportLines);
                break;
            }
        }

        $scrubberRating = '';
        $modifiedReportLines = $reportLines;
        for ($i = 0; $i < $lineLength; $i++) {
            $valuesAtIndex = array_map(static fn (string $reportLine): int => (int)$reportLine[$i], $modifiedReportLines);
            $mostCommon = $this->getLeastCommonNumber($valuesAtIndex);
            $scrubberRating .= $mostCommon;
            $modifiedReportLines = array_filter($modifiedReportLines, static fn(string $reportLine): bool => str_starts_with($reportLine, $scrubberRating));
            if (count($modifiedReportLines) === 1) {
                $scrubberRating = current($modifiedReportLines);
                break;
            }
        }

        return bindec($oxygenRating) * bindec($scrubberRating);
    }

    /**
     * @param int[] $valuesAtIndex
     */
    private function getMostCommonNumber(array $valuesAtIndex): int
    {
        // Since there will only be 1s and 0s we can assume that if the sum of the array is smaller than the total
        // report line count divided by 2 then the majority is 0s, otherwise it's 1s
        // e.g. 1000 lines => 500 is half of it, if the sum is 450 then there are 550 0s
        $onesCount = array_sum($valuesAtIndex);

        if (count($valuesAtIndex) === 2) {
            return 1; // rule of CoA
        }
        return count($valuesAtIndex) / 2 > $onesCount ? 0 : 1;
    }

    /**
     * @param int[] $valuesAtIndex
     */
    private function getLeastCommonNumber(array $valuesAtIndex): int
    {
        // Since there will only be 1s and 0s we can assume that if the sum of the array is smaller than the total
        // report line count divided by 2 then the majority is 0s, otherwise it's 1s
        // e.g. 1000 lines => 500 is half of it, if the sum is 450 then there are 550 0s
        $onesCount = array_sum($valuesAtIndex);

        if (count($valuesAtIndex) === 2) {
            return 0; // rule of CoA
        }
        return count($valuesAtIndex) / 2 > $onesCount ? 1: 0;
    }
}
