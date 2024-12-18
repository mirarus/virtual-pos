<?php

namespace Mirarus\VirtualPos\Models;

use Mirarus\VirtualPos\Interfaces\OrderInterface;

/**
 * Order
 *
 * @package    Mirarus\VirtualPos\Models
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
class Order implements OrderInterface
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
	 * @param $id
	 * @return void
	 */
	public function setId($id): void
	{
		$this->id = $id;
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
	 * @return string
	 */
	public function getLocale(): string
	{
		return $this->locale;
	}

	/**
	 * @param string $locale
	 * @return void
	 */
	public function setLocale(string $locale): void
	{
		$this->locale = $locale;
	}

	/**
	 * @return string
	 */
	public function getCurrency(): string
	{
		return $this->currency;
	}

	/**
	 * @param string $currency
	 * @return void
	 */
	public function setCurrency(string $currency): void
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