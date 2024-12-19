<?php

namespace Mirarus\VirtualPos\Http;

use stdClass;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

/**
 * Request
 *
 * @package    Mirarus\VirtualPos\Http
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
class Request
{
	private $client;

	/**
	 * @param Client $client
	 */
	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	/**
	 * @param $response
	 * @return mixed|stdClass
	 */
	private function createRequest($response)
	{
		return json_decode($response->getBody());
	}

	/**
	 * @param string $endpoint
	 * @param array $data
	 * @param null $response
	 * @return mixed|stdClass|string
	 */
	public function post(string $endpoint, array $data = [], &$response = null)
	{
		try {
			$response = $this->client->post($endpoint, $data);
			return $this->createRequest($response);
		} catch (GuzzleException|ClientException|RequestException|Exception $e) {
			return $this->createRequest($e->getResponse()) ?: $e->getMessage();
		}
	}

	/**
	 * @param string $endpoint
	 * @param null $response
	 * @return mixed|stdClass|string
	 */
	public function get(string $endpoint, &$response = null)
	{
		try {
			$response = $this->client->get($endpoint);
			return $this->createRequest($response);
		} catch (GuzzleException|ClientException|RequestException|Exception $e) {
			return $this->createRequest($e->getResponse()) ?: $e->getMessage();
		}
	}

	/**
	 * @param string $endpoint
	 * @param array $data
	 * @param null $response
	 * @return mixed|stdClass|string
	 */
	public function put(string $endpoint, array $data = [], &$response = null)
	{
		try {
			$response = $this->client->put($endpoint, $data);
			return $this->createRequest($response);
		} catch (GuzzleException|ClientException|RequestException|Exception $e) {
			return $this->createRequest($e->getResponse()) ?: $e->getMessage();
		}
	}

	/**
	 * @param string $endpoint
	 * @param null $response
	 * @return mixed|stdClass|string
	 */
	public function delete(string $endpoint, &$response = null)
	{
		try {
			$response = $this->client->delete($endpoint);
			return $this->createRequest($response);
		} catch (GuzzleException|ClientException|RequestException|Exception $e) {
			return $this->createRequest($e->getResponse()) ?: $e->getMessage();
		}
	}

	/**
	 * @return string
	 */
	public static function getIp(): string
	{
		if (getenv("HTTP_CLIENT_IP")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} elseif (getenv("HTTP_X_FORWARDED_FOR")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
			if (strstr($ip, ',')) {
				$tmp = explode(',', $ip);
				$ip = trim($tmp[0]);
			}
		} else {
			$ip = getenv("REMOTE_ADDR");
		}

		if ($ip) {
			return $ip;
		}

		$keys = array('X_FORWARDED_FOR', 'HTTP_X_FORWARDED_FOR', 'CLIENT_IP', 'REMOTE_ADDR');
		foreach ($keys as $key) {
			if (isset($_SERVER[$key])) {
				return $_SERVER[$key];
			}
		}
		return "";
	}
}