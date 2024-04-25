<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_COOKIE['token']) && !is_null($_COOKIE['token'])) {
		$token = $_COOKIE['token'];
		$url = 'http://localhost:8000/products';
		$client = new Client();
		try {
			$response = $client->request('GET', $url);
			$body = $response
				->getBody()
				->getContents();
			$body = json_decode($body, true);
			$products = $body['data'] ?? [];
			$productsNum = 5;
			$productsLine = (int)ceil(sizeof($products) / (float)$productsNum);
			$priceFmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
			require_once(__DIR__ . '/../template.php');
		} catch (ClientException $e) {
			require_once(__DIR__ . '/../template.php');
		}
	} else {
		header("Location: http://{$_SERVER['HTTP_HOST']}");
		exit();
	}
}
