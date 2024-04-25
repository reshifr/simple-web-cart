<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	require_once(__DIR__ . '/../template.php');
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
			require_once(__DIR__ . '/../template.php');
		}
	} else {
		header("Location: http://{$_SERVER['HTTP_HOST']}/menu/history");
		exit();
	}
}
