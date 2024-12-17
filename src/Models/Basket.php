<?php

namespace Mirarus\VirtualPos\Models;

use InvalidArgumentException;
use Mirarus\VirtualPos\Interfaces\Model;

/**
 * Basket
 *
 * @package    Mirarus\VirtualPos\Models
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.0
 * @since      1.0.0
 */
class Basket implements Model
{
	private $basketItems;

	/**
	 * @return mixed
	 */
	public function getBasketItems()
	{
		return $this->basketItems;
	}

	/**
	 * @param mixed $basketItem
	 */
	public function setBasketItem(BasketItem $basketItem): void
	{
		$this->basketItems[] = $basketItem;
	}
}