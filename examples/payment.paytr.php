<?php

// composer require mirarus/virtual-pos

require "vendor/autoload.php";

use Mirarus\VirtualPos\Models\Basket;
use Mirarus\VirtualPos\Models\BasketItem;
use Mirarus\VirtualPos\Models\Order;
use Mirarus\VirtualPos\VirtualPos;
use Mirarus\VirtualPos\Models\Buyer;
use Mirarus\VirtualPos\Models\Address;
use Mirarus\VirtualPos\Providers\PayTR;
use Mirarus\VirtualPos\Enums\Locale;
use Mirarus\VirtualPos\Enums\Currency;


$PayTR = new PayTR();
$PayTR->setApiId("--api-id--");
$PayTR->setApiKey("--api-key--");
$PayTR->setApiSecret("--api-secret--");
$PayTR->setApiSandbox(true);
$PayTR->setApiDebug(true);
$PayTR->setApiSuccessfulUrl("http://localhost/pay-success");
$PayTR->setApiFailedUrl("http://localhost/pay-failed");


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
$order->setInstallment(1);


$basketItem = new BasketItem();
$basketItem->setName("Ayakkabı");
$basketItem->setPrice("10.30");
$basketItem->setQuantity("1");

$basket = new Basket();
$basket->setBasketItem($basketItem);


$virtualPos = new VirtualPos();
$virtualPos->setProvider($PayTR);
$virtualPos->setBuyer($buyer);
$virtualPos->setAddress($address);
$virtualPos->setOrder($order);
$virtualPos->setBasket($basket);


$createPaymentForm = $virtualPos->createPaymentForm();
var_dump($createPaymentForm);