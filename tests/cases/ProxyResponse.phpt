<?php declare(strict_types = 1);

/**
 * Test: ProxyResponse
 */

use Contributte\Psr7\ProxyResponse;
use Contributte\Psr7\Psr7ResponseFactory;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// withHeader
test(function (): void {
	$response = Psr7ResponseFactory::fromGlobal();

	$proxy = new ProxyResponse($response);

	Assert::same(
		['application/json'],
		$proxy->withHeader('Content-Type', 'application/json')->getHeader('Content-Type')
	);

	Assert::same($response, $proxy->getOriginalResponse());
});
