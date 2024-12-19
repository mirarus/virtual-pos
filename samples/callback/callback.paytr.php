<?php

// composer require mirarus/virtual-pos

require "vendor/autoload.php";

use Mirarus\VirtualPos\VirtualPos;
use Mirarus\VirtualPos\Providers\PayTR;

$PayTR = new PayTR();
$PayTR->setApiKey("--api-key--");
$PayTR->setApiSecret("--api-secret--");

$virtualPos = new VirtualPos();
$virtualPos->setProvider($PayTR);

$createCallback = $virtualPos->createCallback(function($data) {
	print_r($data);
	// CallBack Proccess
});