<?php

use Mirarus\VirtualPos\Models\Order;
use Mirarus\VirtualPos\Enums\Currency;
use Mirarus\VirtualPos\Enums\Locale;

// Set Option
$order = new Order();
$order->setId(10000);
$order->setPrice(100);
$order->setLocale(Locale::TR);
$order->setCurrency(Currency::TL);
$order->setInstallment(1);

// ----------- //

// Get Option
print_r($order->getId());
print_r($order->getPrice());
print_r($order->getLocale());
print_r($order->getCurrency());
print_r($order->getInstallment());