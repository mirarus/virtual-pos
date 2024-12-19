<?php

// composer require mirarus/virtual-pos

require "vendor/autoload.php";

use Mirarus\VirtualPos\VirtualPos;
use Mirarus\VirtualPos\Providers\Iyzico;


$Iyzico = new Iyzico();
$Iyzico->setApiKey("--api-key--");
$Iyzico->setApiSecret("--api-secret--");
$Iyzico->setApiSandbox(true);


$virtualPos = new VirtualPos();
$virtualPos->setProvider($Iyzico);


$createCallback = $virtualPos->createCallback(function($data) {
	print_r($data);
	// CallBack Proccess
});