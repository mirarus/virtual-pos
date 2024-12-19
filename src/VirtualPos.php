<?php

namespace Mirarus\VirtualPos;

use Mirarus\VirtualPos\Interfaces\ProviderInterface;
use Mirarus\VirtualPos\Models\Model;

/**
 * VirtualPos
 *
 * @package    Mirarus\VirtualPos
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
class VirtualPos extends Model
{
	private $provider;

	/**
	 * @return ProviderInterface
	 */
	public function getProvider(): ProviderInterface
	{
		return $this->provider;
	}

	/**
	 * @param ProviderInterface $provider
	 * @return void
	 */
	public function setProvider(ProviderInterface $provider): void
	{
		$this->provider = $provider;
	}

	/**
	 * @return mixed
	 */
	public function createPaymentForm()
	{
		$provider = $this->getProvider();
		$provider->setBuyer($this->getBuyer());
		$provider->setAddress($this->getAddress());
		$provider->setOrder($this->getOrder());
		$provider->setBasket($this->getBasket());

		return $provider->createPaymentForm();
	}

	/**
	 * @param callable $callback
	 * @return mixed
	 */
	public function createCallback(callable $callback): void
	{
		$provider = $this->getProvider();

		if ($this->order !== null) {
			$provider->setOrder($this->getOrder());
		}

		$provider->createCallback($callback);
	}
}