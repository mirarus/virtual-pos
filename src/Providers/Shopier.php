<?php

namespace Mirarus\VirtualPos\Providers;

use Mirarus\VirtualPos\Enums\BasketItemType;
use Mirarus\VirtualPos\Enums\Currency;
use Mirarus\VirtualPos\Enums\Locale;
use stdClass;
use Mirarus\VirtualPos\Interfaces\ProviderInterface;
use Mirarus\VirtualPos\Models\Provider;
use Mirarus\VirtualPos\Http\Request;

/**
 * Shopier
 *
 * @package    Mirarus\VirtualPos\Providers
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.0
 * @since      1.0.0
 */
class Shopier extends Provider implements ProviderInterface
{
	protected $baseUri = "https://www.shopier.com/ShowProduct/api_pay4.php";
	protected $timeout = 30;
	protected $sslVerify = false;
	private $webSiteIndex = 1;


	/**
	 * @return string
	 */
	public function createPaymentForm(): string
	{
		$webSiteIndex = $this->getWebSiteIndex();
		$apiKey = $this->getApiKey();
		$apiSecret = $this->getApiSecret();
		$apiReturnUrl = $this->getApiReturnUrl();

		$buyerId = $this->getBuyer()->getId();
		$buyerEmail = $this->getBuyer()->getEmail();
		$buyerName = $this->getBuyer()->getName();
		$buyerSurname = $this->getBuyer()->getSurname();
		$buyerPhone = $this->getBuyer()->getPhone();

		$addressAddress = $this->getAddress()->getAddress();
		$addressState = $this->getAddress()->getState();
		$addressCity = $this->getAddress()->getCity();
		$addressCountry = $this->getAddress()->getCountry();
		$addressZipCode = $this->getAddress()->getZipCode();
		$address = implode(', ', [$addressAddress, $addressState, $addressCity, $addressCountry, $addressZipCode]);

		$orderId = $this->getOrder()->getId();
		$orderPrice = $this->getOrder()->getPrice();
		$orderCurrency = $this->getOrder()->getCurrency();
		$orderLocale = $this->getOrder()->getLocale();

		$basketItems = $this->getBasket()->getBasketItems();

		$random_nr = uniqid() . "Shopier" . $orderId;
		$amount = round($orderPrice,2);

		if (!empty($basketItems)) {
			$basketArray = [];
			foreach ($basketItems as $item) {
				$productName = $item->getName();
				$productName = str_replace('"', '', $productName);
				$productName = str_replace('&quot;', '', $productName);

				if ($item->getType() == BasketItemType::VIRTUAL) {
					$productType = 1;
				} else if ($item->getType() == BasketItemType::PHYSICAL) {
					$productType = 0;
				} else {
					$productType = 1;
				}

				$basketArray[] = [
				  'name' => trim($productName),
				  'product_id' => $item->getId(),
				  'product_type' => $productType,
				  'quantity' => $item->getQuantity(),
				  'price' =>  round($item->getPrice(),2)
				];
			}
			$basket = htmlspecialchars(json_encode($basketArray, JSON_UNESCAPED_UNICODE));
		} else {
			$basket = null;
		}

		if ($orderCurrency == Currency::TL) {
			$currency = 0;
		} else if ($orderCurrency == Currency::USD) {
			$currency = 1;
		} else if ($orderCurrency == Currency::EUR) {
			$currency = 2;
		} else {
			$currency = 0;
		}

		if ($orderLocale == Locale::TR) {
			$locale = 0;
		} else if ($orderLocale == Locale::EN) {
			$locale = 1;
		} else {
			$locale = 0;
		}

		$formFields = [
		  'API_key' => $apiKey,
		  'website_index' => $webSiteIndex,
		  'platform_order_id' => $orderId,
		  'product_name' => $basket,
		  'product_type' => 1,
		  'buyer_name' => $buyerName,
		  'buyer_surname' => $buyerSurname,
		  'buyer_email' => $buyerEmail,
		  'buyer_account_age' => 0,
		  'buyer_id_nr' => $buyerId,
		  'buyer_phone' => $buyerPhone,
		  'billing_address' => $address,
		  'billing_city' => $addressCity,
		  'billing_country' => $addressCountry,
		  'billing_postcode' => $addressZipCode,
		  'shipping_address' => 'NA',
		  'shipping_city' => 'NA',
		  'shipping_country' => 'NA',
		  'shipping_postcode' => 'NA',
		  'total_order_value' => $amount,
		  'currency' => $currency,
		  'current_language' => $locale,
		  'modul_version' => "1.0.4",
		  'platform' => 4,
		  'is_in_frame' => 0,
		  'random_nr' => $random_nr,
		  'callback_url' => $apiReturnUrl
		];

		$hashData = ($random_nr . $orderId . $amount . $currency);
		$hashToken = base64_encode(hash_hmac('sha256', $hashData . $apiSecret, true));
		$formFields['signature'] = $hashToken;

		$url = $this->baseUri;

		$htmlOutput = '<form method="post" action="' . $url . '">';
		foreach ($formFields as $k => $v) {
			$htmlOutput .= '<input type="hidden" name="' . $k . '" value="' . $v . '" />';
		}
		$htmlOutput .= '<input type="submit"/>';
		$htmlOutput .= '</form>';

		return $htmlOutput;


		/*
				$hashData = $apiId . $userIp . $merchantOid . $userEmail . $amount . $basket . $noInstallment . $maxInstallment . $orderCurrency . $apiSandbox;
				$hashToken = base64_encode(hash_hmac('sha256', $hashData . $apiSecret, $apiKey, true));

				$response = $this->request()->post("get-token", [
				  "form_params" => [
					"merchant_id" => $apiId,
					"merchant_oid" => $merchantOid,
					"payment_amount" => $amount,
					"paytr_token" => $hashToken,
					"no_installment" => $noInstallment,
					"max_installment" => $maxInstallment,
					"user_basket" => $basket,
					"user_ip" => $userIp,
					"email" => $userEmail,
					"user_name" => $userFullName,
					"user_phone" => $userPhone,
					"user_address" => $address,
					"merchant_ok_url" => $apiSuccessfulUrl,
					"merchant_fail_url" => $apiFailedUrl,
					"currency" => $orderCurrency,
					"lang" => $orderLocale,
					"test_mode" => $apiSandbox,
					"debug_on" => $apiDebug,
					"timeout_limit" => 30
				  ]
				]);

				if (!empty($response->token)) {
					return "https://www.paytr.com/odeme/guvenli/" . $response->token;
				} else {
					return $response->reason;
				}*/
	}

	/**
	 * @return void
	 */
	public function createCallback(callable $callback)
	{
		$apiKey = $this->getApiKey();
		$apiSecret = $this->getApiSecret();

		$merchantOid = !empty($_POST['merchant_oid']) ? $_POST['merchant_oid'] : null;
		$status = !empty($_POST['merchant_oid']) ? $_POST['status'] : null;
		$totalAmount = !empty($_POST['merchant_oid']) ? $_POST['total_amount'] : null;
		$hash = !empty($_POST['merchant_oid']) ? $_POST['hash'] : null;

		$hashToken = base64_encode(hash_hmac('sha256', $merchantOid . $apiSecret . $status . $totalAmount, $apiKey, true));

		$orderId = explode('PayTR', $merchantOid);
		$amount = ($totalAmount / 100);

		if ($hashToken != $hash) {
			die('PayTR notification failed: bad hash');
		} else if ($status != 'success') {
			echo "ERROR";
		} else {

			$data = new stdClass();
			$data->orderId = $orderId[1];
			$data->amount = $amount;
			$data->status = $status;

			$callback($data);

			echo "OK";
		}
	}

	public function getWebSiteIndex(): int
	{
		return $this->webSiteIndex;
	}

	public function setWebSiteIndex(int $webSiteIndex): void
	{
		$this->webSiteIndex = $webSiteIndex;
	}
}