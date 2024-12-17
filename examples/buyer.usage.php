<?php

use Mirarus\VirtualPos\Models\Buyer;

// Set Option
$buyer = new Buyer();
$buyer->setId(1);
$buyer->setName("John Doe");
$buyer->setSurname("Smith");
$buyer->setEmail("john@doe.com");
$buyer->setPhone("0123456789");

// ----------- //

// Get Option
print_r($buyer->getId());
print_r($buyer->getName());
print_r($buyer->getSurname());
print_r($buyer->getEmail());
print_r($buyer->getPhone());