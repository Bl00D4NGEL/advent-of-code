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
        $reportLinesCount = count($reportLines);
        // We assume that the first element has the length as every other line
        $lineLength = strlen($reportLines[0]);
        $gammaBits = [];
        for ($i = 0; $i < $lineLength; $i++) {
            // Since there will only be 1s and 0s we can assume that if the sum of the array is smaller than the total
            // report line count divided by 2 then the majority is 0s, otherwise it's 1s
            // e.g. 1000 lines => 500 is half of it, if the sum is 450 then there are 550 0s
            $onesCount = array_sum(array_map(static fn (string $reportLine): int => (int)$reportLine[$i], $reportLines));

            if ($reportLinesCount / 2 > $onesCount) {
                $bit = 1;
            } else {
                $bit = 0;
            }

            $gammaBits = [
                ...$gammaBits,
                $bit,
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
}
