<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_COOKIE['token']) && !is_null($_COOKIE['token'])) {
		header("Location: http://{$_SERVER['HTTP_HOST']}/menu");
		exit();
	}
	require_once(__DIR__ . '/template.php');
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$url = 'http://localhost:8000/login';
	$client = new Client();
	try {
		$response = $client->request('POST', $url, [
			'form_params' => [
				'username' => $_POST['username'] ?? null,
				'password' => $_POST['password'] ?? null,
			]
		]);
		$body = $response
			->getBody()
			->getContents();
		$body = json_decode($body, true);
		$token = $body['token'] ?? null;
		setcookie('token', $token, time() + (86400 * 30), "/");
		setcookie('logout_token', $token, time() + (86400 * 30), "/");
		header("Location: http://{$_SERVER['HTTP_HOST']}/menu");
		exit();
	} catch (ClientException $e) {
		$body = $e
			->getResponse()
			->getBody()
			->getContents();
		$body = json_decode($body, true);
		$error = $body['error'] ?? null;
		require_once(__DIR__ . '/template.php');
	}
}
