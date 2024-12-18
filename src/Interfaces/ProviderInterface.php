<?php

namespace Mirarus\VirtualPos\Interfaces;

/**
 * ProviderInterface
 *
 * @package    Mirarus\VirtualPos\Interfaces
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
interface ProviderInterface
{
	/**
	 * @param $apiId
	 * @return void
	 */
	public function setApiId($apiId): void;

	/**
	 * @param string $apiKey
	 * @return void
	 */
	public function setApiKey(string $apiKey): void;

	/**
	 * @param string $apiSecret
	 * @return void
	 */
	public function setApiSecret(string $apiSecret): void;

	/**
	 * @param bool $apiSandbox
	 * @return void
	 */
	public function setApiSandbox(bool $apiSandbox): void;

	/**
	 * @param bool $apiDebug
	 * @return void
	 */
	public function setApiDebug(bool $apiDebug): void;

	/**
	 * @return string
	 */
	public function getApiReturnUrl(): string;

	/**
	 * @param string $apiReturnUrl
	 * @return void
	 */
	public function setApiReturnUrl(string $apiReturnUrl): void;

	/**
	 * @return string
	 */
	public function getApiSuccessfulUrl(): string;

	/**
	 * @param string $apiSuccessfulUrl
	 * @return void
	 */
	public function setApiSuccessfulUrl(string $apiSuccessfulUrl): void;

	/**
	 * @return string
	 */
	public function getApiFailedUrl(): string;

	/**
	 * @param string $apiFailedUrl
	 * @return void
	 */
	public function setApiFailedUrl(string $apiFailedUrl): void;
}