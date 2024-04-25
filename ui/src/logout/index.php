<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_COOKIE['token']) && !is_null($_COOKIE['token'])) {
		$token = $_COOKIE['token'];
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
