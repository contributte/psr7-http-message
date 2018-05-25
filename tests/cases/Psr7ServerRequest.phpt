<?php declare(strict_types = 1);

/**
 * Test: Psr7ServerRequest
 */

use Contributte\Psr7\Exception\Logical\InvalidStateException;
use Contributte\Psr7\Psr7ServerRequest;
use Contributte\Psr7\Psr7ServerRequestFactory;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// of
test(function (): void {
	$request = Psr7ServerRequestFactory::fromGlobal()
		->withHeader('X-Foo', 'bar')
		->withMethod('PUT');

	Assert::equal('PUT', $request->getMethod());

	$clone = Psr7ServerRequest::of($request);

	Assert::equal('PUT', $clone->getMethod());
});

// withAttributes
test(function (): void {
	$request = Psr7ServerRequestFactory::fromGlobal()
		->withAttributes(['X-Foo' => 'bar', 'X-Bar' => 'baz']);

	Assert::equal('GET', $request->getMethod());
	Assert::equal('bar', $request->getAttribute('X-Foo'));
	Assert::equal('baz', $request->getAttribute('X-Bar'));
});

// normalizeNetteFiles
test(function (): void {
	Assert::throws(function (): void {
		Psr7ServerRequest::normalizeNetteFiles([new stdClass()]);
	}, InvalidArgumentException::class, 'Invalid value in files specification');
});

// QueryParams
test(function (): void {
	$_GET['foo'] = 'bar';
	$request = Psr7ServerRequestFactory::fromSuperGlobal();

	Assert::true($request->hasQueryParam('foo'));
	Assert::equal('bar', $request->getQueryParam('foo'));
	Assert::equal('baz', $request->getQueryParam('foobar', 'baz'));

	Assert::throws(function () use ($request): void {
		$request->getQueryParam('baz');
	}, InvalidStateException::class, 'No query parameter "baz" found');
});
