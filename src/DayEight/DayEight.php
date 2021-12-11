<?php

declare(strict_types=1);

namespace App\DayEight;

final class DayEight
{
    private const NUMBER_MAP = [
        'abcefg' => 0,
        'cf' => 1,
        'acdeg' => 2,
        'acdfg' => 3,
        'bcdf' => 4,
        'abdfg' => 5,
        'abdefg' => 6,
        'acf' => 7,
        'abcdefg' => 8,
        'abcdfg' => 9,
    ];

    public function getOccurrences(): int
    {
        $input = file_get_contents(__DIR__ . '/Fixture/input.txt');

        $occurrences = 0;
        $lines = explode("\n", $input);
        foreach ($lines as $line) {
            [, $second] = explode(' | ', $line);
            $secondParts = explode(' ', $second);
            // We only want the digits that are 2, 3, 4 or 7 characters long
            // Which represent 1, 7, 4 and 8 respectively
            $filtered = array_filter(
                $secondParts,
                static fn (string $val): bool => in_array(strlen($val), [2, 3, 4, 7], true)
            );

            $occurrences += count($filtered);
        }

        return $occurrences;
    }

    public function getDecodedSum(): int
    {
        $input = file_get_contents(__DIR__ . '/Fixture/input.txt');

        $lines = explode("\n", $input);

        $totalSum = 0;
        foreach ($lines as $line) {
            [$first, $second] = explode(' | ', $line);
            $firstParts = explode(' ', $first);
            $translationMap = $this->getTranslationMAp($firstParts);
            $secondParts = explode(' ', $second);
            $translatedParts = array_map(
                static function (string $secondPart) use ($translationMap): string {
                    $parts = array_map(
                        static fn (string $part): string => $translationMap[$part],
                        str_split($secondPart)
                    );
                    return implode('', $parts);
                },
                $secondParts
            );
            $translatedParts = $this->sortStringsAlphabetically($translatedParts);

            $numberMap = self::NUMBER_MAP;

            $sum = array_map(static fn (string $translatedPart): int => $numberMap[$translatedPart], $translatedParts);

            $sum = (int)(implode('', $sum));
            $totalSum += $sum;
        }


        return $totalSum;
    }

    private function sortStringsAlphabetically(array $strings): array
    {
        return array_map(static function (string $string): string {
            $sorted = str_split($string);
            sort($sorted);
            return implode('', $sorted);
        }, $strings);
    }

    private function getTranslationMAp(array $firstParts): array
    {
        // We only want the digits that are 2, 3 and 4 characters long
        // Which represent 1, 7 and 4 respectively
        $two = current($this->filterByStringLength($firstParts, 2));
        $three = current($this->filterByStringLength($firstParts, 3));
        $four = current($this->filterByStringLength($firstParts, 4));

        $diffThree = array_diff(str_split($three), str_split($two));
        $actualA = current($diffThree);

        $normalBd = array_diff(str_split($four), str_split($two));

        $normals = implode('', $normalBd) . $three . $actualA;
        $normalEg = array_diff(str_split('abcdefg'), str_split($normals));

        $fiveCharacterLongStrings = $this->filterByStringLength($firstParts, 5);

        foreach ($fiveCharacterLongStrings as $fiveCharacterLongString) {
            $diff = array_diff(str_split($fiveCharacterLongString), str_split($three));
            // The diff needs to be 2. We need to find 3 characters in 5 character long words
            // 5 - 3 = 2
            if (count($diff) === 2) {
                $diffEg = array_diff($diff, $normalEg);
                $actualD = current($diffEg);

                $diffG = array_Diff($normalEg, $diff);
                $actualE = current($diffG);

                $diffBd = array_diff($diff, $normalBd);
                $actualG = current($diffBd);

                $diffD = array_Diff($normalBd, $diff);
                $actualB = current($diffD);
                break;
            }
        }

        foreach ($fiveCharacterLongStrings as $fiveCharacterLongString) {
            $expectedTwoStrings = [
                $actualA,
                $actualD,
                $actualE,
                $actualG,
            ];
            // we need actual c now

            $diff = array_diff(str_split($fiveCharacterLongString), $expectedTwoStrings);
            if (count($diff) === 1) {
                $actualC = current($diff);
                break;
            }
        }
        $diffFull = array_diff(str_split('abcdefg'), [
            $actualA,
            $actualB,
            $actualC,
            $actualD,
            $actualE,
            $actualG,
        ]);
        $actualF = current($diffFull);

        return [
            $actualA => 'a',
            $actualB => 'b',
            $actualC => 'c',
            $actualD => 'd',
            $actualE => 'e',
            $actualF => 'f',
            $actualG => 'g',
        ];
    }

    private function filterByStringLength(array $strings, int $length): array
    {
        return array_filter(
            $strings,
            static fn (string $val): bool => strlen($val) === $length
        );
    }
}