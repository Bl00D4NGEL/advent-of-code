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
}