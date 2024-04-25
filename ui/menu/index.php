<?php

require_once(__DIR__ . '/../vendor/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	header("Location: http://{$_SERVER['HTTP_HOST']}/menu/product");
	exit();
}
