<?php

namespace Mirarus\VirtualPos\Interfaces;

/**
 * AddressInterface
 *
 * @package    Mirarus\VirtualPos\Interfaces
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
interface AddressInterface
{
	/**
	 * @return mixed
	 */
	public function getAddress();

	/**
	 * @param $address
	 * @return void
	 */
	public function setAddress($address): void;

	/**
	 * @return mixed
	 */
	public function getCity();

	/**
	 * @param $city
	 * @return void
	 */
	public function setCity($city): void;

	/**
	 * @return mixed
	 */
	public function getState();

	/**
	 * @param $state
	 * @return void
	 */
	public function setState($state): void;

	/**
	 * @return mixed
	 */
	public function getZipCode();

	/**
	 * @param $zipCode
	 * @return void
	 */
	public function setZipCode($zipCode): void;

	/**
	 * @return mixed
	 */
	public function getCountry();

	/**
	 * @param $country
	 * @return void
	 */
	public function setCountry($country): void;
}