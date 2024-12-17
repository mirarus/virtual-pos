<?php

namespace Mirarus\VirtualPos\Models;

use Mirarus\VirtualPos\Http\Request;
use Mirarus\VirtualPos\Interfaces\Model;
use GuzzleHttp\Client;
use InvalidArgumentException;

/**
 * Provider
 *
 * @package    Mirarus\VirtualPos\Models
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.0
 * @since      1.0.0
 */
abstract class Provider implements Model
{
	private $apiId;
	private $apiKey;
	private $apiSecret;
	private $apiSandbox = false;
	private $apiDebug = false;
	private $apiReturnUrl;
	private $apiSuccessfulUrl;
	private $apiFailedUrl;

	private $buyer;
	private $address;
	private $order;
	private $basket;

	/**
	 * @return Request
	 */
	protected function request(): Request
	{
		$client = new Client([
		  'base_uri' => $this->baseUri,
		  'timeout' => $this->timeout,
		  'verify' => $this->sslVerify
		]);

		return new Request($client);
	}

	/**
	 * @return void
	 */
	protected function createPaymentForm()
	{
	}

	/**
	 * @param callable $callback
	 * @return void
	 */
	protected function createCallback(callable $callback)
	{
	}

	/**
	 * @return mixed
	 */
	protected function getApiId()
	{
		return $this->apiId;
	}

	/**
	 * @param mixed $apiId
	 */
	public function setApiId($apiId): void
	{
		$this->apiId = $apiId;
	}

	/**
	 * @return mixed
	 */
	protected function getApiKey()
	{
		return $this->apiKey;
	}

	/**
	 * @param mixed $apiKey
	 */
	public function setApiKey($apiKey): void
	{
		$this->apiKey = $apiKey;
	}

	/**
	 * @return mixed
	 */
	protected function getApiSecret()
	{
		return $this->apiSecret;
	}

	/**
	 * @param mixed $apiSecret
	 */
	public function setApiSecret($apiSecret): void
	{
		$this->apiSecret = $apiSecret;
	}

	/**
	 * @return bool
	 */
	public function isApiSandbox(): bool
	{
		return $this->apiSandbox;
	}

	/**
	 * @param bool $apiSandbox
	 * @return void
	 */
	public function setApiSandbox(bool $apiSandbox): void
	{
		$this->apiSandbox = $apiSandbox;
	}

	/**
	 * @return bool
	 */
	public function isApiDebug(): bool
	{
		return $this->apiDebug;
	}

	/**
	 * @param bool $apiDebug
	 * @return void
	 */
	public function setApiDebug(bool $apiDebug): void
	{
		$this->apiDebug = $apiDebug;
	}

	/**
	 * @return mixed
	 */
	public function getApiReturnUrl()
	{
		return $this->apiReturnUrl;
	}

	/**
	 * @param mixed $apiReturnUrl
	 */
	public function setApiReturnUrl($apiReturnUrl): void
	{
		$this->apiReturnUrl = $apiReturnUrl;
	}

	/**
	 * @return mixed
	 */
	public function getApiSuccessfulUrl()
	{
		return $this->apiSuccessfulUrl;
	}

	/**
	 * @param mixed $apiSuccessfulUrl
	 */
	public function setApiSuccessfulUrl($apiSuccessfulUrl): void
	{
		$this->apiSuccessfulUrl = $apiSuccessfulUrl;
	}

	/**
	 * @return mixed
	 */
	public function getApiFailedUrl()
	{
		return $this->apiFailedUrl;
	}

	/**
	 * @param mixed $apiFailedUrl
	 */
	public function setApiFailedUrl($apiFailedUrl): void
	{
		$this->apiFailedUrl = $apiFailedUrl;
	}

	/**
	 * @return Buyer
	 */
	public function getBuyer(): Buyer
	{
		if ($this->buyer instanceof Buyer) {
			return $this->buyer;
		}
		throw new InvalidArgumentException("Buyer must be an instance of Buyer.");
	}

	/**
	 * @param Model $buyer
	 * @return void
	 */
	public function setBuyer(Model $buyer): void
	{
		$this->buyer = $buyer;
	}

	/**
	 * @return Address
	 */
	public function getAddress(): Address
	{
		if ($this->address instanceof Address) {
			return $this->address;
		}
		throw new InvalidArgumentException("Address must be an instance of Address.");
	}

	/**
	 * @param Model $address
	 * @return void
	 */
	public function setAddress(Model $address): void
	{
		$this->address = $address;
	}

	/**
	 * @return Order
	 */
	public function getOrder(): Order
	{
		if ($this->order instanceof Order) {
			return $this->order;
		}
		throw new InvalidArgumentException("Order must be an instance of Order.");
	}

	/**
	 * @param Model $order
	 * @return void
	 */
	public function setOrder(Model $order): void
	{
		$this->order = $order;
	}

	/**
	 * @return Basket
	 */
	public function getBasket(): Basket
	{
		if ($this->basket instanceof Basket) {
			return $this->basket;
		}
		throw new InvalidArgumentException("Basket must be an instance of Basket.");
	}

	/**
	 * @param Model $basket
	 * @return void
	 */
	public function setBasket(Model $basket): void
	{
		$this->basket = $basket;
	}
}