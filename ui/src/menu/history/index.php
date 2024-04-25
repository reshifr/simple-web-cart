<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_COOKIE['token']) && !is_null($_COOKIE['token'])) {
		$token = $_COOKIE['token'];
		$url = 'http://localhost:8000/history';
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
			$history = $body['data'] ?? [];
			$priceFmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
			date_default_timezone_set('Asia/Jakarta');
			setlocale(LC_TIME, 'id_ID');
			require_once(__DIR__ . '/../template.php');
		} catch (ClientException $e) {
			header("Location: http://{$_SERVER['HTTP_HOST']}/login");
			exit();
		}
	} else {
		header("Location: http://{$_SERVER['HTTP_HOST']}/login");
		exit();
	}
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_COOKIE['token']) && !is_null($_COOKIE['token'])) {
		$token = $_COOKIE['token'];
		$url = 'http://localhost:8000/cart/checkout';
		$client = new Client();
		try {
			$response = $client->request('POST', $url, [
				'headers' => [
					'Authorization' => 'Bearer ' . $token
				]
			]);
			header("Location: http://{$_SERVER['HTTP_HOST']}/menu/history");
			exit();
		} catch (ClientException $e) {
			header("Location: http://{$_SERVER['HTTP_HOST']}/login");
			exit();
		}
	}
}
