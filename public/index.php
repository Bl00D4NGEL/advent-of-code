<?php

use App\DayFive\DayFive;
use App\DayFour\DayFour;
use App\DayOne\DayOne;
use App\DaySeven\DaySeven;
use App\DaySix\DaySix;
use App\DayThree\DayThree;
use App\DayTwo\DayTwo;

require_once __DIR__ .'/../vendor/autoload.php';

$dayOne = new DayOne();
print "Day 1 Part 1 Increments: " . $dayOne->getIncrements() . PHP_EOL;
print "Day 1 Part 2 Increments: " . $dayOne->getGroupsIncrements() . PHP_EOL;

$dayTwo = new DayTwo();
print "Day 2 Part 1 Result: " . $dayTwo->getResult() . PHP_EOL;
print "Day 2 Part 2 Result: " . $dayTwo->getResultWithAim() . PHP_EOL;

$dayThree = new DayThree();
print "Day 3 Part 1 Result: " . $dayThree->getPowerConsumption() . PHP_EOL;
print "Day 3 Part 2 Result: " . $dayThree->getRating() . PHP_EOL;

$dayFour = new DayFour();
print "Day 4 Part 1 Result: " . $dayFour->getResultForFirstBoardToWin() . PHP_EOL;
print "Day 4 Part 2 Result: " . $dayFour->getResultForLastBoardToWin() . PHP_EOL;

$dayFive = new DayFive();
print "Day 5 Part 1 Result: " . $dayFive->getOverlapCount() . PHP_EOL;
print "Day 5 Part 2 Result: " . $dayFive->getDiagonalOverlapCount() . PHP_EOL;

$daySix = new DaySix();
print "Day 6 Part 1 Result: " . $daySix->simulate(80) . PHP_EOL;
print "Day 6 Part 2 Result: " . $daySix->simulate(256) . PHP_EOL;

$daySeven = new DaySeven();
print "Day 7 Part 1 Result: " . $daySeven->getCheapestOutcome() . PHP_EOL;
