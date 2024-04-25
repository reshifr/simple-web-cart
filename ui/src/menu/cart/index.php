<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_COOKIE['token']) && !is_null($_COOKIE['token'])) {
		$token = $_COOKIE['token'];
		$url = 'http://localhost:8000/cart';
		$client = new Client();
		try {
			$response = $client->request('GET', $url, [
				'headers' => [
					'Authorization' => 'Bearer ' . $token
				]
			]);
			$body = $response
				->getBody()
				->getContents();
			$body = json_decode($body, true);
			$items = $body['data'] ?? [];
			$total = array_reduce($items, function ($total, $item) {
				return $total + ($item['amount'] ?? 0) * ($item['price'] ?? 0);
			});
			$coupons = 0;
			if ($total > 50_000) {
				$coupons += (int)($total / 100_000) + 1;
			}
			$priceFmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
			$total = $priceFmt->formatCurrency((float)$total, "IDR");
			require_once(__DIR__ . '/../template.php');
		} catch (ClientException $e) {
			require_once(__DIR__ . '/../template.php');
		}
	} else {
		header("Location: http://{$_SERVER['HTTP_HOST']}/menu/cart");
		exit();
	}
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_COOKIE['token']) && !is_null($_COOKIE['token'])) {
		$token = $_COOKIE['token'];
		$url = 'http://localhost:8000/cart/add';
		$client = new Client();
		try {
			$response = $client->request('POST', $url, [
				'headers' => [
					'Authorization' => 'Bearer ' . $token
				],
				'form_params' => [
					'id' => $_POST['id'] ?? null,
					'amount' => $_POST['amount'] ?? null,
				]
			]);
			header("Location: http://{$_SERVER['HTTP_HOST']}/menu/cart");
			exit();
		} catch (ClientException $e) {
			require_once(__DIR__ . '/../template.php');
		}
	} else {
		header("Location: http://{$_SERVER['HTTP_HOST']}/menu/cart");
		exit();
	}
}
