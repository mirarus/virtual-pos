<?php

namespace Mirarus\VirtualPos\Interfaces;

/**
 * BasketInterface
 *
 * @package    Mirarus\VirtualPos\Interfaces
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
interface BasketInterface
{
	/**
	 * @return mixed
	 */
	public function getBasketItems();

	/**
	 * @param BasketItemInterface $basketItem
	 * @return void
	 */
	public function setBasketItem(BasketItemInterface $basketItem): void;

	/**
	 * @return string
	 */
	public function getName(): string;

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName(string $name): void;

	/**
	 * @return string
	 */
	public function getType(): string;

	/**
	 * @param string $type
	 * @return void
	 */
	public function setType(string $type): void;
}