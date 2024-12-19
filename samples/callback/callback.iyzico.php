<?php

// composer require mirarus/virtual-pos

require "vendor/autoload.php";

use Mirarus\VirtualPos\Models\Order;
use Mirarus\VirtualPos\Enums\Locale;
use Mirarus\VirtualPos\VirtualPos;
use Mirarus\VirtualPos\Providers\Iyzico;

$Iyzico = new Iyzico();
$Iyzico->setApiKey("--api-key--");
$Iyzico->setApiSecret("--api-secret--");
$Iyzico->setApiSandbox(true);

$order = new Order();
$order->setId(10000);
$order->setLocale(Locale::TR);

$virtualPos = new VirtualPos();
$virtualPos->setProvider($Iyzico);
$virtualPos->setOrder($order);

$createCallback = $virtualPos->createCallback(function($data) {
	print_r($data);
	// CallBack Proccess
});