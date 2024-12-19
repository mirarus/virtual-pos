<?php

// composer require mirarus/virtual-pos

require "vendor/autoload.php";

use Mirarus\VirtualPos\VirtualPos;
use Mirarus\VirtualPos\Providers\Shopier;


$Shopier = new Shopier();
$Shopier->setApiSecret("--api-secret--");


$virtualPos = new VirtualPos();
$virtualPos->setProvider($Shopier);


$createCallback = $virtualPos->createCallback(function($data) {
	print_r($data);
	// CallBack Proccess
});