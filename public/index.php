<?php

require_once __DIR__ .'/../vendor/autoload.php';

$task = new \App\DayOne\DayOne();
print "Increments: " . $task->getIncrements() . PHP_EOL;
