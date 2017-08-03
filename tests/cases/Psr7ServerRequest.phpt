<?php

/**
 * Test: Psr7ServerRequest
 */

use Contributte\Psr7\Psr7ServerRequest;
use Contributte\Psr7\Psr7ServerRequestFactory;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// of
test(function () {
	$request = Psr7ServerRequestFactory::fromGlobal()
		->withHeader('X-Foo', 'bar')
		->withMethod('PUT');

	Assert::equal('PUT', $request->getMethod());

	$clone = Psr7ServerRequest::of($request);

	Assert::equal('PUT', $clone->getMethod());
});
