<?php

namespace Mirarus\VirtualPos\Providers;

use stdClass;
use Mirarus\VirtualPos\Util;
use Mirarus\VirtualPos\Http\Request;
use Mirarus\VirtualPos\Enums\Currency;
use Mirarus\VirtualPos\Models\Provider;
use Mirarus\VirtualPos\Interfaces\ProviderInterface;

/**
 * Iyzico
 *
 * @package    Mirarus\VirtualPos\Providers
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.0
 * @since      1.0.0
 */
class Iyzico extends Provider implements ProviderInterface
{
	protected $baseUri = "https://api.iyzipay.com/payment/";
	protected $baseUriSandbox = "https://sandbox-api.iyzipay.com/payment/";
	protected $timeout = 30;
	protected $sslVerify = false;

	/**
	 * @return string
	 */
	public function createPaymentForm(): string
	{
		$apiKey = $this->getApiKey();
		$apiSecret = $this->getApiSecret();
		$apiSandbox = $this->isApiSandbox();
		$apiReturnUrl = $this->getApiReturnUrl();

		$buyerIp = Request::getIp();
		$buyerId = $this->getBuyer()->getId();
		$buyerEmail = $this->getBuyer()->getEmail();
		$buyerName = $this->getBuyer()->getName();
		$buyerSurname = $this->getBuyer()->getSurname();
		$buyerFullName = $this->getBuyer()->getFullName();
		$buyerPhone = $this->getBuyer()->getPhone();
		$buyerIdentityNumber = $this->getBuyer()->getIdentityNumber();

		$addressAddress = $this->getAddress()->getAddress();
		$addressCity = $this->getAddress()->getCity();
		$addressCountry = $this->getAddress()->getCountry();
		$addressZipCode = $this->getAddress()->getZipCode();

		$orderId = $this->getOrder()->getId();
		$orderPrice = $this->getOrder()->getPrice();
		$orderCurrency = $this->getOrder()->getCurrency();
		$orderLocale = strtolower($this->getOrder()->getLocale());
		$orderInstallments = $this->getOrder()->getInstallments();
		$basketItems = $this->getBasket()->getBasketItems();

		$this->baseUri = $apiSandbox ? $this->baseUriSandbox : $this->baseUri;

		if ($orderCurrency == Currency::TL) {
			$orderCurrency = "TRY";
		}

		$totalPrice = array_reduce($basketItems, function ($carry, $item) {
			return $carry + (float)Util::formatPrice($item->getPrice());
		}, 0);

		$object = new stdClass;
		$object->locale = $orderLocale;
		$object->conversationId = $orderId;
		$object->price = $totalPrice;
		$object->basketId = $orderId;
		$object->paymentGroup = "PRODUCT";

		$object->buyer = new stdClass;
		$object->buyer->id = $buyerId;
		$object->buyer->name = $buyerName;
		$object->buyer->surname = $buyerSurname;
		$object->buyer->identityNumber = $buyerIdentityNumber;
		$object->buyer->email = $buyerEmail;
		$object->buyer->gsmNumber = $buyerPhone;
		$object->buyer->registrationAddress = $addressAddress;
		$object->buyer->city = $addressCity;
		$object->buyer->country = $addressCountry;
		$object->buyer->zipCode = $addressZipCode;
		$object->buyer->ip = $buyerIp;

		$object->shippingAddress = new stdClass;
		$object->shippingAddress->address = $addressAddress;
		$object->shippingAddress->zipCode = $addressZipCode;
		$object->shippingAddress->contactName = $buyerFullName;
		$object->shippingAddress->city = $addressCity;
		$object->shippingAddress->country = $addressCountry;

		$object->billingAddress = new stdClass;
		$object->billingAddress->address = $addressAddress;
		$object->billingAddress->zipCode = $addressZipCode;
		$object->billingAddress->contactName = $buyerFullName;
		$object->billingAddress->city = $addressCity;
		$object->billingAddress->country = $addressCountry;

		if (!empty($basketItems)) {
			foreach ($basketItems as $key => $item) {
				$object->basketItems[$key] = new stdClass();
				$object->basketItems[$key]->id = $item->getId();
				$object->basketItems[$key]->price = Util::formatPrice($item->getPrice());
				$object->basketItems[$key]->name = $item->getName();
				$object->basketItems[$key]->category1 = $item->getCategory();
				$object->basketItems[$key]->itemType = $item->getType();
			}
		}

		$object->callbackUrl = $apiReturnUrl;
		$object->currency = $orderCurrency;
		$object->paidPrice = Util::formatPrice($orderPrice);
		$object->enabledInstallments = $orderInstallments;

		$generatePki = $this->generatePKI($object);
		$generateSignature = $this->generateSignature($generatePki, $apiKey, $apiSecret);
		$jsonOutput = json_encode($object, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

		$response = $this->request()->post("iyzipos/checkoutform/initialize/auth/ecom", [
		  "body" => $jsonOutput,
		  "headers" => [
			"Authorization" => $generateSignature->token,
			"x-iyzi-rnd" => $generateSignature->randNum,
			"Content-Type" => 'application/json',
		  ]
		]);

		if ($response->status == 'success') {
			header("Location: " . $response->paymentPageUrl);
			die();
		} else {
			return $response->errorMessage;
		}
	}

	/**
	 * @return void
	 */
	public function createCallback(callable $callback)
	{
		$apiKey = $this->getApiKey();
		$apiSecret = $this->getApiSecret();
		$apiSandbox = $this->isApiSandbox();

		$orderId = $this->getOrder()->getId();
		$orderLocale = strtolower($this->getOrder()->getLocale());

		$this->baseUri = $apiSandbox ? $this->baseUriSandbox : $this->baseUri;

		$token = !empty($_POST['token']) ? $_POST['token'] : null;

		$object = new stdClass();
		$object->locale = $orderLocale;
		$object->conversationId = $orderId;
		$object->token = $token;

		$generatePki = $this->generatePKI($object);
		$generateSignature = $this->generateSignature($generatePki, $apiKey, $apiSecret);
		$jsonOutput = json_encode($object, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

		$response = $this->request()->post("iyzipos/checkoutform/auth/ecom/detail", [
		  "body" => $jsonOutput,
		  "headers" => [
			"Authorization" => $generateSignature->token,
			"x-iyzi-rnd" => $generateSignature->randNum,
			"Content-Type" => 'application/json',
		  ]
		]);

		if ($response->status != 'success') {
			die('Iyzico notification failed: bad parameters');
		} else if ($response->paymentStatus != 'SUCCESS' || $orderId != $response->conversationId) {
			echo $response->errorMessage;
		} else {

			$data = new stdClass();
			$data->orderId = $response->conversationId;
			$data->status = ($response->paymentStatus == 'SUCCESS');
			$data->paymentData = $response;

			$callback($data);
		}
	}

	/**
	 * @param $pki
	 * @param $apiKey
	 * @param $apiSecret
	 * @return stdClass
	 */
	private function generateSignature($pki, $apiKey, $apiSecret): stdClass
	{
		$randNum = rand(1000000000, 9999999999);
		$hashData = ($apiKey . $randNum . $apiSecret . $pki);
		$hash = base64_encode(sha1($hashData, true));

		$token = 'IYZWS ' . $apiKey . ':' . $hash;

		$data = new stdClass;
		$data->token = $token;
		$data->randNum = $randNum;

		return $data;
	}

	/**
	 * @param $request
	 * @return string
	 */
	private function generatePKI($request): string
	{
		$isArray = is_array($request);
		$requestString = '[';

		foreach ($request as $key => $val) {
			if ($val !== null && !is_callable($val)) {
				if (!$isArray) {
					$requestString .= $key . '=';
				}
				if (is_array($val) || is_object($val)) {
					$requestString .= $this->generatePKI($val);
				} else {
					$requestString .= $val;
				}
				$requestString .= $isArray ? ', ' : ',';
			}
		}

		$requestString = rtrim($requestString, $isArray ? ', ' : ',');
		$requestString .= ']';

		return $requestString;
	}
}