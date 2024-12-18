<?php

// composer require mirarus/virtual-pos

require "vendor/autoload.php";

use Mirarus\VirtualPos\Enums\BasketType;
use Mirarus\VirtualPos\Models\Basket;
use Mirarus\VirtualPos\Models\Order;
use Mirarus\VirtualPos\VirtualPos;
use Mirarus\VirtualPos\Models\Buyer;
use Mirarus\VirtualPos\Models\Address;
use Mirarus\VirtualPos\Providers\Shopier;
use Mirarus\VirtualPos\Enums\Locale;
use Mirarus\VirtualPos\Enums\Currency;


$Shopier = new Shopier();
$Shopier->setApiKey("--api-key--");
$Shopier->setApiSecret("--api-secret--");
$Shopier->setWebSiteIndex(1);
$Shopier->setApiReturnUrl("http://localhost/pay-callback");

$buyer = new Buyer();
$buyer->setId(1);
$buyer->setName("John Doe");
$buyer->setSurname("Smith");
$buyer->setEmail("john@doe.com");
$buyer->setPhone("0123456789");


$address = new Address();
$address->setAddress("... Mah. ... Sok. No: ...");
$address->setState("Keçiören");
$address->setCity("Ankara");
$address->setCountry("Turkey");
$address->setZipCode("06000");


$order = new Order();
$order->setId(10000);
$order->setPrice(100);
$order->setLocale(Locale::TR);
$order->setCurrency(Currency::TL);


$basket = new Basket();
$basket->setName("Ayakkabı");
$basket->setType(BasketType::PHYSICAL);


$virtualPos = new VirtualPos();
$virtualPos->setProvider($Shopier);
$virtualPos->setBuyer($buyer);
$virtualPos->setAddress($address);
$virtualPos->setOrder($order);
$virtualPos->setBasket($basket);


$createPaymentForm = $virtualPos->createPaymentForm();
var_dump($createPaymentForm);