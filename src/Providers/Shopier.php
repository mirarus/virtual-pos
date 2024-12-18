<?php

namespace Mirarus\VirtualPos\Providers;

use stdClass;
use Mirarus\VirtualPos\Enums\BasketType;
use Mirarus\VirtualPos\Enums\Currency;
use Mirarus\VirtualPos\Enums\Locale;
use Mirarus\VirtualPos\Interfaces\ProviderInterface;
use Mirarus\VirtualPos\Models\Provider;

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

		$basketName = $this->getBasket()->getName();
		$basketType = $this->getBasket()->getType();

		$amount = round($orderPrice, 2);
		$random_nr = rand(100000, 999999);

		$productName = str_replace('"', '', $basketName);
		$productName = str_replace('&quot;', '', $productName);

		if ($basketType == BasketType::VIRTUAL) {
			$productType = 1;
		} else if ($basketType == BasketType::PHYSICAL) {
			$productType = 0;
		} else {
			$productType = 1;
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
		  'product_name' => $productName,
		  'product_type' => $productType,
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
		  'platform' => 0,
		  'is_in_frame' => 0,
		  'random_nr' => $random_nr,
		  'callback_url' => $apiReturnUrl
		];

		$hashData = ($random_nr . $orderId . $amount . $currency);
		$hashToken = base64_encode(hash_hmac('sha256', $hashData, $apiSecret, true));
		$formFields['signature'] = $hashToken;

		$formOutput = '<form id="shopier_payment_form" method="post" action="' . htmlspecialchars($this->baseUri, ENT_QUOTES, 'UTF-8') . '">';
		foreach ($formFields as $k => $v) {
			$formOutput .= '<input type="hidden" name="' . htmlspecialchars($k, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars($v, ENT_QUOTES, 'UTF-8') . '" />';
		}
		$formOutput .= '</form><script type="text/javascript">document.getElementById("shopier_payment_form").submit();</script>';

		return $formOutput;
	}

	/**
	 * @return void
	 */
	public function createCallback(callable $callback)
	{
		$apiSecret = $this->getApiSecret();

		$orderId = !empty($_REQUEST['platform_order_id']) ? $_REQUEST['platform_order_id'] : null;
		$signature = !empty($_REQUEST['signature']) ? $_REQUEST['signature'] : null;
		$randomNr = !empty($_REQUEST['random_nr']) ? $_REQUEST['random_nr'] : null;
		$status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : null;
		$errorMessage = !empty($_REQUEST['error_message']) ? $_REQUEST['error_message'] : null;

		$status = strtolower($status);
		$signature = base64_decode($signature);
		$expected = hash_hmac('SHA256', ($randomNr . $orderId), $apiSecret, true);

		if ($signature != $expected) {
			die('Shopier notification failed: bad signature');
		} else if ($status != 'success') {
			echo $errorMessage;
		} else {

			$data = new stdClass();
			$data->orderId = $orderId;
			$data->status = $status;

			$callback($data);
		}
	}

	/**
	 * @return int
	 */
	public function getWebSiteIndex(): int
	{
		return $this->webSiteIndex;
	}

	/**
	 * @param int $webSiteIndex
	 * @return void
	 */
	public function setWebSiteIndex(int $webSiteIndex): void
	{
		$this->webSiteIndex = $webSiteIndex;
	}
}