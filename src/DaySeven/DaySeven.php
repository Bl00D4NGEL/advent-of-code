<?php

declare(strict_types=1);

namespace App\DaySeven;

final class DaySeven
{
    public function getCheapestOutcome(): int
    {
        $input = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $crabs = explode(',', $input);
        $min = min($crabs);
        $max = max($crabs);
        $fuelCosts = [];
        for ($i = $min; $i <= $max; $i++) {
            $fuelCost = 0;
            foreach ($crabs as $crab) {
                $fuelCost += abs($crab - $i);
            }
            $fuelCosts[$i] = $fuelCost;
        }

        asort($fuelCosts);
        return current($fuelCosts);
    }

    public function getCheapestOutcomeNew(): int
    {
        $input = file_get_contents(__DIR__ . '/Fixture/input.txt');
        $crabs = explode(',', $input);
        $min = min($crabs);
        $max = max($crabs);
        $fuelCosts = [];
        for ($i = $min; $i <= $max; $i++) {
            $fuelCost = 0;
            foreach ($crabs as $crab) {
                $distance = abs($crab - $i);
                // To get sum of x..y one can use the formula (y/2)*(x+y)
                // e.g. 1..11 = (11/2)*(1+11) = 5.5*12 = 66
                $fuelCost += (int)(($distance / 2) * (1 + $distance));
            }
            $fuelCosts[$i] = $fuelCost;
        }

        asort($fuelCosts);
        return current($fuelCosts);
    }
}