<?php

require_once(__DIR__ . '/../vendor/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	require_once(__DIR__ . '/template.php');
}
