<?php

namespace Mirarus\VirtualPos\Models;

use Mirarus\VirtualPos\Interfaces\ModelInterface;
use Mirarus\VirtualPos\Interfaces\BuyerInterface;
use Mirarus\VirtualPos\Interfaces\AddressInterface;
use Mirarus\VirtualPos\Interfaces\OrderInterface;
use Mirarus\VirtualPos\Interfaces\BasketInterface;

/**
 * Model
 *
 * @package    Mirarus\VirtualPos\Models
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.0
 * @since      1.0.0
 */
abstract class Model implements ModelInterface
{
	protected $buyer;
	protected $address;
	protected $order;
	protected $basket;

	/**
	 * @return BuyerInterface
	 */
	public function getBuyer(): BuyerInterface
	{
		return $this->buyer;
	}

	/**
	 * @param BuyerInterface $buyer
	 * @return void
	 */
	public function setBuyer(BuyerInterface $buyer): void
	{
		$this->buyer = $buyer;
	}

	/**
	 * @return AddressInterface
	 */
	public function getAddress(): AddressInterface
	{
		return $this->address;
	}

	/**
	 * @param AddressInterface $address
	 * @return void
	 */
	public function setAddress(AddressInterface $address): void
	{
		$this->address = $address;
	}

	/**
	 * @return OrderInterface
	 */
	public function getOrder(): OrderInterface
	{
		return $this->order;
	}

	/**
	 * @param OrderInterface $order
	 * @return void
	 */
	public function setOrder(OrderInterface $order): void
	{
		$this->order = $order;
	}

	/**
	 * @return BasketInterface
	 */
	public function getBasket(): BasketInterface
	{
		return $this->basket;
	}

	/**
	 * @param BasketInterface $basket
	 * @return void
	 */
	public function setBasket(BasketInterface $basket): void
	{
		$this->basket = $basket;
	}
}