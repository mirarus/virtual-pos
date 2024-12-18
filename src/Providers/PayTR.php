<?php

namespace Mirarus\VirtualPos\Providers;

use stdClass;
use Mirarus\VirtualPos\Interfaces\ProviderInterface;
use Mirarus\VirtualPos\Models\Provider;
use Mirarus\VirtualPos\Http\Request;

/**
 * PayTR
 *
 * @package    Mirarus\VirtualPos\Providers
 * @author     Ali Güçlü <aliguclutr@gmail.com>
 * @copyright  Copyright (c) 2024
 * @license    MIT
 * @version    1.0.1
 * @since      1.0.0
 */
class PayTR extends Provider implements ProviderInterface
{
	protected $baseUri = "https://www.paytr.com/odeme/api/";
	protected $timeout = 30;
	protected $sslVerify = false;

	/**
	 * @return string
	 */
	public function createPaymentForm(): string
	{
		$apiId = $this->getApiId();
		$apiKey = $this->getApiKey();
		$apiSecret = $this->getApiSecret();
		$apiSuccessfulUrl = $this->getApiSuccessfulUrl();
		$apiFailedUrl = $this->getApiFailedUrl();
		$apiSandbox = ($this->isApiSandbox() !== null ? 1 : 0);
		$apiDebug = ($this->isApiDebug() !== null ? 1 : 0);

		$userIp = Request::getIp();
		$userEmail = $this->getBuyer()->getEmail();
		$userName = $this->getBuyer()->getName();
		$userSurname = $this->getBuyer()->getSurname();
		$userPhone = $this->getBuyer()->getPhone();
		$userFullName = implode(' ', [$userName, $userSurname]);

		$addressAddress = $this->getAddress()->getAddress();
		$addressState = $this->getAddress()->getState();
		$addressCity = $this->getAddress()->getCity();
		$addressCountry = $this->getAddress()->getCountry();
		$addressZipCode = $this->getAddress()->getZipCode();
		$address = implode(', ', [$addressAddress, $addressState, $addressCity, $addressCountry, $addressZipCode]);

		$orderId = $this->getOrder()->getId();
		$orderPrice = $this->getOrder()->getPrice();
		$orderCurrency = $this->getOrder()->getCurrency();
		$orderLocale = strtolower($this->getOrder()->getLocale());
		$orderInstallment = $this->getOrder()->getInstallment();

		$basketItems = $this->getBasket()->getBasketItems();

		$maxInstallment = ($orderInstallment > 0) ? $orderInstallment : 0;
		$noInstallment = ($orderInstallment > 0) ? 1 : 0;

		$merchantOid = uniqid() . "PayTR" . $orderId;
		$amount = (number_format($orderPrice, 2, '.', '') * 100);

		if (!empty($basketItems)) {
			$basketArray = [];
			foreach ($basketItems as $item) {
				$basketArray[] = [$item->getName(), round($item->getPrice(), 2), $item->getQuantity()];
			}
			$basket = base64_encode(json_encode($basketArray));
		} else {
			$basket = null;
		}

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
		}
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
}