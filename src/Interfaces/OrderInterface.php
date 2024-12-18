<?php

namespace Mirarus\VirtualPos\Interfaces;

/**
 * OrderInterface
 *
 * @package    Mirarus\VirtualPos\Interfaces
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
interface OrderInterface
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
	 * @return float
	 */
	public function getPrice(): float;

	/**
	 * @param float $price
	 * @return void
	 */
	public function setPrice(float $price): void;

	/**
	 * @return string
	 */
	public function getLocale(): string;

	/**
	 * @param string $locale
	 * @return void
	 */
	public function setLocale(string $locale): void;

	/**
	 * @return string
	 */
	public function getCurrency(): string;

	/**
	 * @param string $currency
	 * @return void
	 */
	public function setCurrency(string $currency): void;

	/**
	 * @return int
	 */
	public function getInstallment(): int;

	/**
	 * @param int $installment
	 * @return void
	 */
	public function setInstallment(int $installment): void;
}