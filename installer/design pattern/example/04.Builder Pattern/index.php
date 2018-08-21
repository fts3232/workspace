<?php

require('Builder.php');
require('Bike.php');
require('BikeBuilder.php');

$builder = new Builder\BikeBuilder();
$builder->buildTyres();
$builder->buildFrame();
$builder->buildGPS();
var_dump($builder->getBike());
