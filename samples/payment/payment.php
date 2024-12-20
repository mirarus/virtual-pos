<?php

// composer require mirarus/virtual-pos

require "vendor/autoload.php";


use Mirarus\VirtualPos\Enums\Locale;
use Mirarus\VirtualPos\Enums\Currency;
use Mirarus\VirtualPos\Enums\BasketItemType;
use Mirarus\VirtualPos\Models\Basket;
use Mirarus\VirtualPos\Models\BasketItem;
use Mirarus\VirtualPos\Models\Order;
use Mirarus\VirtualPos\Models\Buyer;
use Mirarus\VirtualPos\Models\Address;
use Mirarus\VirtualPos\VirtualPos;
use Mirarus\VirtualPos\Providers\PayTR;
use Mirarus\VirtualPos\Providers\Iyzico;
use Mirarus\VirtualPos\Providers\Shopier;

// PayTR için
$PayTR = new PayTR();
$PayTR->setApiId("--api-id--");
$PayTR->setApiKey("--api-key--");
$PayTR->setApiSecret("--api-secret--");
$PayTR->setApiSandbox(true);
$PayTR->setApiDebug(true);
$PayTR->setApiSuccessfulUrl("http://localhost/pay-success");
$PayTR->setApiFailedUrl("http://localhost/pay-failed");

// Iyzico için
$Iyzico = new Iyzico();
$Iyzico->setApiKey("--api-key--");
$Iyzico->setApiSecret("--api-secret--");
$Iyzico->setApiSandbox(true);
$Iyzico->setApiReturnUrl("http://localhost/pay-callback");

// Shopier için
$Shopier = new Shopier();
$Shopier->setApiKey("--api-key--");
$Shopier->setApiSecret("--api-secret--");
$Shopier->setWebSiteIndex(1);
$Shopier->setApiReturnUrl("http://localhost/pay-callback");


// Ortak Kullanım - Müşteri Bilgileri
$buyer = new Buyer();
$buyer->setId(1);
$buyer->setName("John Doe");
$buyer->setSurname("Smith");
$buyer->setEmail("john@doe.com");
$buyer->setPhone("905000000000");
$buyer->setIdentityNumber("11111111111");


// Ortak Kullanım - Müşteri Adres Bilgileri
$address = new Address();
$address->setAddress("... Mah. ... Sok. No: ...");
$address->setState("Keçiören");
$address->setCity("Ankara");
$address->setCountry("Turkey");
$address->setZipCode("06000");

// setInstallment Harici, Ortak Kullanım - Sipariş Bilgileri
$order = new Order();
$order->setId(10000);
$order->setPrice(10);
$order->setLocale(Locale::TR);
$order->setCurrency(Currency::TL);
$order->setInstallment(1); // Taksit Sayısı (PayTR için)
$order->setInstallments([1]); // Taksit Sayıları (Iyzico için)

// Ortak Kullanım - Sepet İçeriği
$basketItem = new BasketItem();
$basketItem->setId(1);
$basketItem->setName("Ayakkabı");
$basketItem->setPrice("10.30");
$basketItem->setQuantity(1);
$basketItem->setCategory("Giyim");
$basketItem->setType(BasketItemType::PHYSICAL);

// Ortak Kullanım - Sepet Bilgileri
$basket = new Basket();
$basket->setBasketItem($basketItem); // Sepet İçeriği (Shopier için ilk tanımlanan basketItem geçerli olacaktır)

// Sınıf Başlatma
$virtualPos = new VirtualPos();
$virtualPos->setProvider($PayTR); // $PayTR, $Iyzico veya $Shopier
$virtualPos->setBuyer($buyer);
$virtualPos->setAddress($address);
$virtualPos->setOrder($order);
$virtualPos->setBasket($basket);

// Ödeme Formu Oluştur
echo $virtualPos->createPaymentForm();