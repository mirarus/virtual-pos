<?php

namespace Mirarus\VirtualPos\Models;

use Mirarus\VirtualPos\Interfaces\BasketInterface;
use Mirarus\VirtualPos\Interfaces\BasketItemInterface;

/**
 * Basket
 *
 * @package    Mirarus\VirtualPos\Models
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.2
 * @since      1.0.0
 */
class Basket implements BasketInterface
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
	 * @param BasketItemInterface $basketItem
	 * @return void
	 */
	public function setBasketItem(BasketItemInterface $basketItem): void
	{
		$this->basketItems[] = $basketItem;
	}
}