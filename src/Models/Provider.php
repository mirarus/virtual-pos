<?php

namespace Mirarus\VirtualPos\Models;

use Mirarus\VirtualPos\Interfaces\ProviderInterface;
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
abstract class Provider extends Model implements ProviderInterface
{
	private $apiKey;
	private $apiSecret;
	private $apiSandbox = false;
	private $apiDebug = false;
	private $apiReturnUrl;
	private $apiSuccessfulUrl;
	private $apiFailedUrl;

	/**
	 * @return string
	 */
	protected function getApiKey(): string
	{
		return $this->apiKey;
	}

	/**
	 * @param string $apiKey
	 * @return void
	 */
	public function setApiKey(string $apiKey): void
	{
		$this->apiKey = $apiKey;
	}

	/**
	 * @return string
	 */
	protected function getApiSecret(): string
	{
		return $this->apiSecret;
	}

	/**
	 * @param string $apiSecret
	 * @return void
	 */
	public function setApiSecret(string $apiSecret): void
	{
		$this->apiSecret = $apiSecret;
	}

	/**
	 * @return bool
	 */
	protected function isApiSandbox(): bool
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
	protected function isApiDebug(): bool
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
	 * @return string
	 */
	public function getApiReturnUrl(): string
	{
		return $this->apiReturnUrl;
	}

	/**
	 * @param string $apiReturnUrl
	 * @return void
	 */
	public function setApiReturnUrl(string $apiReturnUrl): void
	{
		$this->apiReturnUrl = $apiReturnUrl;
	}

	/**
	 * @return string
	 */
	public function getApiSuccessfulUrl(): string
	{
		return $this->apiSuccessfulUrl;
	}

	/**
	 * @param string $apiSuccessfulUrl
	 * @return void
	 */
	public function setApiSuccessfulUrl(string $apiSuccessfulUrl): void
	{
		$this->apiSuccessfulUrl = $apiSuccessfulUrl;
	}

	/**
	 * @return string
	 */
	public function getApiFailedUrl(): string
	{
		return $this->apiFailedUrl;
	}

	/**
	 * @param string $apiFailedUrl
	 * @return void
	 */
	public function setApiFailedUrl(string $apiFailedUrl): void
	{
		$this->apiFailedUrl = $apiFailedUrl;
	}

	/**
	 * @param array $options
	 * @return Request
	 */
	protected function request(array $options = []): Request
	{
		$client = new Client(array_merge([
		  'base_uri' => $this->baseUri,
		  'timeout' => $this->timeout,
		  'verify' => $this->sslVerify
		], $options));

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
}