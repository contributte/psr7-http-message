<?php

/**
 * Test: Psr7ResponseFactory
 */

use Contributte\Psr7\Psr7ResponseFactory;
use Nette\Http\Response;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// Global
test(function () {
	$response = Psr7ResponseFactory::fromGlobal();
	$response = $response->withStatus(300);
	Assert::equal(300, $response->getStatusCode());
});

// Nette - factory
test(function () {
	$netteResponse = new Response();
	$netteResponse->setCode(300);
	$response = Psr7ResponseFactory::fromNette($netteResponse);
	Assert::equal(300, $response->getStatusCode());
});
