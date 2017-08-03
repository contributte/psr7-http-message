<?php

/**
 * Test: Psr7Response
 */

use Contributte\Psr7\Psr7Response;
use Contributte\Psr7\Psr7ResponseFactory;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// getBody
test(function () {
	$response = Psr7ResponseFactory::fromGlobal();
	$response->getBody()->write('FOO');
	$response->getBody()->rewind();

	Assert::equal(3, $response->getBody()->getSize());
	Assert::equal('FOO', $response->getBody()->getContents());
});

// getContents
test(function () {
	$response = Psr7ResponseFactory::fromGlobal();
	$response->writeBody('FOO');

	Assert::equal('FOO', $response->getContents());
});

// setBody
test(function () {
	$response = Psr7ResponseFactory::fromGlobal();
	$response->setBody('FOO');

	Assert::equal('FOO', $response->getContents());
});

// appendBody
test(function () {
	$response = Psr7ResponseFactory::fromGlobal();
	$response->setBody('FOO');
	$response->appendBody('BAR');

	Assert::equal('FOOBAR', $response->getContents());
});

// of
test(function () {
	$response = Psr7ResponseFactory::fromGlobal()
		->withStatus(205)
		->withHeader('X-Foo', 'bar')
		->setBody('FOOBAR');

	Assert::equal('FOOBAR', $response->getContents());

	$clone = Psr7Response::of($response);

	Assert::equal(205, $clone->getStatusCode());
	Assert::equal('FOOBAR', $clone->getContents());
});
