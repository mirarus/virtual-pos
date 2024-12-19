<?php

// composer require mirarus/virtual-pos

require "vendor/autoload.php";

use Mirarus\VirtualPos\Enums\BasketItemType;
use Mirarus\VirtualPos\Models\Basket;
use Mirarus\VirtualPos\Models\BasketItem;
use Mirarus\VirtualPos\Models\Order;
use Mirarus\VirtualPos\Providers\Iyzico;
use Mirarus\VirtualPos\VirtualPos;
use Mirarus\VirtualPos\Models\Buyer;
use Mirarus\VirtualPos\Models\Address;
use Mirarus\VirtualPos\Enums\Locale;
use Mirarus\VirtualPos\Enums\Currency;


$Iyzico = new Iyzico();
$Iyzico->setApiKey("--api-key--");
$Iyzico->setApiSecret("--api-secret--");
$Iyzico->setApiSandbox(true);
$Iyzico->setApiReturnUrl("http://localhost/pay-callback");


$buyer = new Buyer();
$buyer->setId(1);
$buyer->setName("John Doe");
$buyer->setSurname("Smith");
$buyer->setEmail("john@doe.com");
$buyer->setPhone("905360000000");
$buyer->setIdentityNumber("11111111111");


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
$order->setInstallments([1]);


$basketItem = new BasketItem();
$basketItem->setId("1");
$basketItem->setName("Ayakkabı");
$basketItem->setPrice("10.30");
$basketItem->setQuantity("1");
$basketItem->setCategory("Giyim");
$basketItem->setType(BasketItemType::PHYSICAL);

$basket = new Basket();
$basket->setBasketItem($basketItem);


$virtualPos = new VirtualPos();
$virtualPos->setProvider($Iyzico);
$virtualPos->setBuyer($buyer);
$virtualPos->setAddress($address);
$virtualPos->setOrder($order);
$virtualPos->setBasket($basket);


$createPaymentForm = $virtualPos->createPaymentForm();
print_r($createPaymentForm);