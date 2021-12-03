<?php

use App\DayOne\DayOne;

require_once __DIR__ .'/../vendor/autoload.php';

$task = new DayOne();
print "Day 1 Part 1 Increments: " . $task->getIncrements() . PHP_EOL;
print "Day 1 Part 2 Increments: " . $task->getGroupsIncrements() . PHP_EOL;
