<?php

namespace Mirarus\VirtualPos;

use InvalidArgumentException;
use Mirarus\VirtualPos\Interfaces\Model;
use Mirarus\VirtualPos\Models\Provider;

/**
 * VirtualPos
 *
 * @package    Mirarus\VirtualPos
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.0
 * @since      1.0.0
 */
class VirtualPos
{
	public $provider;
	public $buyer;
	public $address;
	public $order;
	public $basket;

	/**
	 * @return Provider
	 */
	public function getProvider(): Provider
	{
		if ($this->provider instanceof Provider) {
			return $this->provider;
		}
		throw new InvalidArgumentException("Provider must be an instance of Provider.");
	}

	/**
	 * @param Provider $provider
	 * @return void
	 */
	public function setProvider(Provider $provider): void
	{
		$this->provider = $provider;
	}

	/**
	 * @return Model
	 */
	public function getBuyer(): Model
	{
		if ($this->buyer instanceof Model) {
			return $this->buyer;
		}
		throw new InvalidArgumentException("Address must be an instance of Model.");
	}

	/**
	 * @param Model $buyer
	 * @return void
	 */
	public function setBuyer(Model $buyer): void
	{
		$this->buyer = $buyer;
	}

	/**
	 * @return Model
	 */
	public function getAddress(): Model
	{
		if ($this->address instanceof Model) {
			return $this->address;
		}
		throw new InvalidArgumentException("Address must be an instance of Model.");
	}

	/**
	 * @param Model $address
	 * @return void
	 */
	public function setAddress(Model $address): void
	{
		$this->address = $address;
	}

	/**
	 * @return Model
	 */
	public function getOrder(): Model
	{
		if ($this->order instanceof Model) {
			return $this->order;
		}
		throw new InvalidArgumentException("Order must be an instance of Model.");
	}

	/**
	 * @param Model $order
	 * @return void
	 */
	public function setOrder(Model $order): void
	{
		$this->order = $order;
	}

	/**
	 * @return Model
	 */
	public function getBasket(): Model
	{
		if ($this->basket instanceof Model) {
			return $this->basket;
		}
		throw new InvalidArgumentException("Basket must be an instance of Model.");
	}

	/**
	 * @param Model $basket
	 * @return void
	 */
	public function setBasket(Model $basket): void
	{
		$this->basket = $basket;
	}

	/**
	 * @return mixed
	 */
	public function createPaymentForm()
	{
		$provider = $this->getProvider();
		$provider->setBuyer($this->getBuyer());
		$provider->setAddress($this->getAddress());
		$provider->setOrder($this->getOrder());
		$provider->setBasket($this->getBasket());

		return $provider->createPaymentForm();
	}

	/**
	 * @param callable $callback
	 * @return null
	 */
	public function createCallback(callable $callback)
	{
		$provider = $this->getProvider();

		return $provider->createCallback($callback);
	}
}