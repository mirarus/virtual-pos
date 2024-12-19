<?php

use Mirarus\VirtualPos\Models\Address;

// Set Option
$address = new Address();
$address->setAddress("... Mah. ... Sok. No: ...");
$address->setState("Keçiören");
$address->setCity("Ankara");
$address->setCountry("Turkey");
$address->setZipCode("06000");

// ----------- //

// Get Option
print_r($address->getAddress());
print_r($address->getState());
print_r($address->getCity());
print_r($address->getCountry());
print_r($address->getZipCode());