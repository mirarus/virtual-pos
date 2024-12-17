<?php

namespace Mirarus\VirtualPos\Models;

use Mirarus\VirtualPos\Interfaces\Model;

/**
 * Order
 *
 * @package    Mirarus\VirtualPos\Models
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.0
 * @since      1.0.0
 */
class Order implements Model
{
	private $id;
	private $price = 0.0;
	private $locale;
	private $currency;
	private $installment = 0;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id): void
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
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
	 * @return mixed
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**
	 * @param mixed $locale
	 */
	public function setLocale($locale): void
	{
		$this->locale = $locale;
	}

	/**
	 * @return mixed
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * @param mixed $currency
	 */
	public function setCurrency($currency): void
	{
		$this->currency = $currency;
	}

	/**
	 * @return int
	 */
	public function getInstallment(): int
	{
		return $this->installment;
	}

	/**
	 * @param int $installment
	 * @return void
	 */
	public function setInstallment(int $installment): void
	{
		$this->installment = $installment;
	}
}