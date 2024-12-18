<?php

namespace Mirarus\VirtualPos\Interfaces;

/**
 * BasketItemInterface
 *
 * @package    Mirarus\VirtualPos\Interfaces
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
interface BasketItemInterface
{
	/**
	 * @return mixed
	 */
	public function getId();

	/**
	 * @param $id
	 * @return void
	 */
	public function setId($id): void;

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
	 * @return float
	 */
	public function getPrice(): float;

	/**
	 * @param float $price
	 * @return void
	 */
	public function setPrice(float $price): void;

	/**
	 * @return int
	 */
	public function getQuantity(): int;

	/**
	 * @param int $quantity
	 * @return void
	 */
	public function setQuantity(int $quantity): void;

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