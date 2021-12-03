<?php

use App\DayOne\DayOne;
use App\DayTwo\DayTwo;

require_once __DIR__ .'/../vendor/autoload.php';

$dayOne = new DayOne();
print "Day 1 Part 1 Increments: " . $dayOne->getIncrements() . PHP_EOL;
print "Day 1 Part 2 Increments: " . $dayOne->getGroupsIncrements() . PHP_EOL;

$dayTwo = new DayTwo();
print "Day 2 Part 1 Result: " . $dayTwo->getResult() . PHP_EOL;
