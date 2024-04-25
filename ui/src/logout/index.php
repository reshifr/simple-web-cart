<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_COOKIE['logout_token']) && !is_null($_COOKIE['logout_token'])) {
		$token = $_COOKIE['logout_token'];
		$url = 'http://localhost:8000/logout';
		$client = new Client();
		try {
			$response = $client->request('DELETE', $url, [
				'headers' => [
					'Authorization' => 'Bearer ' . $token
				]
			]);
		} catch (ClientException $e) {
		}
	}
	header("Location: http://{$_SERVER['HTTP_HOST']}/login");
	exit();
}
