<?php

require_once(__DIR__ . '/../../vendor/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_COOKIE['token']) && !is_null($_COOKIE['token'])) {
		header("Location: http://{$_SERVER['HTTP_HOST']}/menu/product");
		exit();
	}
	header("Location: http://{$_SERVER['HTTP_HOST']}");
	exit();
}
