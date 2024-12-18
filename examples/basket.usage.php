<?php

use Mirarus\VirtualPos\Models\BasketItem;
use Mirarus\VirtualPos\Models\Basket;
use Mirarus\VirtualPos\Enums\BasketItemType;


// Set Option
$basketItem = new BasketItem();
$basketItem->setId("BI101");
$basketItem->setName("Binocular");
$basketItem->setPrice("0.3");
$basketItem->setQuantity("1");
$basketItem->setType(BasketItemType::PHYSICAL);

$basket = new Basket();
$basket->setBasketItem($basketItem);

// ----------- //

// Get Option
print_r($basketItem->getId());
print_r($basketItem->getName());
print_r($basketItem->getPrice());
print_r($basketItem->getQuantity());
print_r($basketItem->getType());

print_r($basket->getBasketItems());