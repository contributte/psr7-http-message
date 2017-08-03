<?php

/**
 * Test: Psr7Response
 */

use Contributte\Psr7\Psr7ResponseFactory;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// Body
test(function () {
	$response = Psr7ResponseFactory::fromGlobal();
	$response->getBody()->write('FOO');
	$response->getBody()->rewind();

	Assert::equal(3, $response->getBody()->getSize());
	Assert::equal('FOO', $response->getBody()->getContents());
});

// Body
test(function () {
	$response = Psr7ResponseFactory::fromGlobal();
	$response->writeBody('FOO');

	Assert::equal(3, $response->getBody()->getSize());
	Assert::equal('FOO', $response->getContents());
});
