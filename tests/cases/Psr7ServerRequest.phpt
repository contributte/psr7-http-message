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

// withAttributes
test(function () {
	$request = Psr7ServerRequestFactory::fromGlobal()
		->withAttributes(['X-Foo' => 'bar', 'X-Bar' => 'baz']);

	Assert::equal('GET', $request->getMethod());
	Assert::equal('bar', $request->getAttribute('X-Foo'));
	Assert::equal('baz', $request->getAttribute('X-Bar'));
});

// hasQueryParam
test(function () {
	$_GET['FOO'] = 'bar';
	$request = Psr7ServerRequestFactory::fromSuperGlobal();

	Assert::true($request->hasQueryParam('FOO'));
	Assert::false($request->hasQueryParam('BAR'));
	Assert::equal('bar', $request->getQueryParam('FOO'));
	Assert::equal('baz', $request->getQueryParam('BAR', 'baz'));
});
