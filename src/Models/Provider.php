<?php

namespace Mirarus\VirtualPos\Models;

use Mirarus\VirtualPos\Http\Request;
use GuzzleHttp\Client;

/**
 * Provider
 *
 * @package    Mirarus\VirtualPos\Models
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
abstract class Provider extends Model
{
	private $apiId;
	private $apiKey;
	private $apiSecret;
	private $apiSandbox = false;
	private $apiDebug = false;
	private $apiReturnUrl;
	private $apiSuccessfulUrl;
	private $apiFailedUrl;

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
}