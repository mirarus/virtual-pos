<?php

namespace Mirarus\VirtualPos;

/**
 * Util
 *
 * @package    Mirarus\VirtualPos
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.0
 * @since      1.0.0
 */
class Util
{
	/**
	 * @param $price
	 * @return string
	 */
	public static function formatPrice($price): string
	{
		if (strpos($price, '.') === false) {
			return $price . '.0';
		}

		$formattedPrice = rtrim($price, '0');

		if (substr($formattedPrice, -1) === '.') {
			$formattedPrice .= '0';
		}

		return $formattedPrice;
	}
}