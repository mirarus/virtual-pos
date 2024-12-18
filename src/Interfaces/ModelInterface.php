<?php

namespace Mirarus\VirtualPos\Interfaces;

/**
 * ModelInterface
 *
 * @package    Mirarus\VirtualPos\Interfaces
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.0
 * @since      1.0.0
 */
interface ModelInterface
{
	/**
	 * @return BuyerInterface
	 */
	public function getBuyer(): BuyerInterface;

	/**
	 * @param BuyerInterface $buyer
	 * @return void
	 */
	public function setBuyer(BuyerInterface $buyer): void;

	/**
	 * @return AddressInterface
	 */
	public function getAddress(): AddressInterface;

	/**
	 * @param AddressInterface $address
	 * @return void
	 */
	public function setAddress(AddressInterface $address): void;

	/**
	 * @return OrderInterface
	 */
	public function getOrder(): OrderInterface;

	/**
	 * @param OrderInterface $order
	 * @return void
	 */
	public function setOrder(OrderInterface $order): void;

	/**
	 * @return BasketInterface
	 */
	public function getBasket(): BasketInterface;

	/**
	 * @param BasketInterface $basket
	 * @return void
	 */
	public function setBasket(BasketInterface $basket): void;
}