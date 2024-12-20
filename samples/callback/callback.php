<?php

// composer require mirarus/virtual-pos

require "vendor/autoload.php";

use Mirarus\VirtualPos\VirtualPos;
use Mirarus\VirtualPos\Providers\PayTR;
use Mirarus\VirtualPos\Providers\Iyzico;
use Mirarus\VirtualPos\Providers\Shopier;


// PayTR için
$PayTR = new PayTR();
$PayTR->setApiKey("--api-key--");
$PayTR->setApiSecret("--api-secret--");


// Iyzico için
$Iyzico = new Iyzico();
$Iyzico->setApiKey("--api-key--");
$Iyzico->setApiSecret("--api-secret--");
$Iyzico->setApiSandbox(true);


// Shopier için
$Shopier = new Shopier();
$Shopier->setApiSecret("--api-secret--");

// Sınıf Başlatma
$virtualPos = new VirtualPos();
$virtualPos->setProvider($PayTR); // $PayTR, $Iyzico veya $Shopier


// CallBack İşlemi - DB İşlemleri vs. yapılabilir, Return Gönderilemez
$createCallback = $virtualPos->createCallback(function($data) {
	// data: [orderId, status, paymentData]
	// PayTR callback tarafında gönderilmesi istenen OK ifadesi dahili olarak aktarılmaktadır.

	print_r($data);
	// CallBack Proccess
});