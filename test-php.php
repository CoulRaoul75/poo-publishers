<?php

require "vendor/autoload.php";

$fakerFR = \Faker\Factory::create();

echo $fakerFR->firstName . " " . $fakerFR->name;
echo "\n";
echo $fakerFR->bs;

