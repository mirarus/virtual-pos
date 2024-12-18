<?php

namespace Mirarus\VirtualPos\Models;

use Mirarus\VirtualPos\Interfaces\BasketItemInterface;

/**
 * BasketItem
 *
 * @package    Mirarus\VirtualPos\Models
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
class BasketItem implements BasketItemInterface
{
	private $id;
	private $name;
	private $price = 0.0;
	private $quantity = 1;
	private $type;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param $id
	 * @return void
	 */
	public function setId($id): void
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return float
	 */
	public function getPrice(): float
	{
		return $this->price;
	}

	/**
	 * @param float $price
	 * @return void
	 */
	public function setPrice(float $price): void
	{
		$this->price = $price;
	}

	/**
	 * @return int
	 */
	public function getQuantity(): int
	{
		return $this->quantity;
	}

	/**
	 * @param int $quantity
	 * @return void
	 */
	public function setQuantity(int $quantity): void
	{
		$this->quantity = $quantity;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return void
	 */
	public function setType(string $type): void
	{
		$this->type = $type;
	}
}