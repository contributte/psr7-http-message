<?php

/**
 * Test: Psr7Request
 */

use Contributte\Psr7\Psr7Request;
use Contributte\Psr7\Psr7RequestFactory;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// of
test(function () {
	$request = Psr7RequestFactory::fromGlobal()
		->withHeader('X-Foo', 'bar')
		->withMethod('PUT');

	Assert::equal('PUT', $request->getMethod());

	$clone = Psr7Request::of($request);

	Assert::equal('PUT', $clone->getMethod());
});
