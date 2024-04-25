<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$url = 'http://localhost:8000/products';
	$client = new Client();
	try {
		$response = $client->request('GET', $url);
		$body = $response
			->getBody()
			->getContents();
		$body = json_decode($body, true);
		$data = $body['data'] ?? [];
		$dataNum = 5;
		$dataLine = (int)ceil(sizeof($data) / (float)$dataNum);
		$priceFmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
		// print_r($data);
		require_once(__DIR__ . '/../template.php');
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
