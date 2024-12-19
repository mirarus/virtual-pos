<?php

namespace Mirarus\VirtualPos\Models;

use Mirarus\VirtualPos\Interfaces\AddressInterface;

/**
 * Address
 *
 * @package    Mirarus\VirtualPos\Models
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.2
 * @since      1.0.0
 */
class Address implements AddressInterface
{
	private $address;
	private $city;
	private $state;
	private $zipCode;
	private $country;

	/**
	 * @return mixed
	 */
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * @param $address
	 * @return void
	 */
	public function setAddress($address): void
	{
		$this->address = $address;
	}

	/**
	 * @return mixed
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @param $city
	 * @return void
	 */
	public function setCity($city): void
	{
		$this->city = $city;
	}

	/**
	 * @return mixed
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * @param $state
	 * @return void
	 */
	public function setState($state): void
	{
		$this->state = $state;
	}

	/**
	 * @return mixed
	 */
	public function getZipCode()
	{
		return $this->zipCode;
	}

	/**
	 * @param $zipCode
	 * @return void
	 */
	public function setZipCode($zipCode): void
	{
		$this->zipCode = $zipCode;
	}

	/**
	 * @return mixed
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param $country
	 * @return void
	 */
	public function setCountry($country): void
	{
		$this->country = $country;
	}

	/**
	 * @return string
	 */
	public function getFullAddress(): string
	{
		return implode(', ', [$this->address, $this->state, $this->city, $this->country, $this->zipCode]);
	}
}