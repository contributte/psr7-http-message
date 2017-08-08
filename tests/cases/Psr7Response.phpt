<?php

/**
 * Test: Psr7Response
 */

use Contributte\Psr7\Exception\Logical\InvalidStateException;
use Contributte\Psr7\Psr7Response;
use Contributte\Psr7\Psr7ResponseFactory;
use Nette\Application\IResponse as IApplicationResponse;
use Nette\Application\Responses\TextResponse;
use Nette\Http\IResponse;
use Nette\Http\Response;
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

// writeBody
test(function () {
	$response = Psr7ResponseFactory::fromGlobal();

	$response->writeBody('FOO');
	Assert::equal('FOO', $response->getContents());

	$response->writeBody('BAR');
	Assert::equal('FOOBAR', $response->getContents());

	$response->writeBody(NULL);
	Assert::equal('FOOBAR', $response->getContents());
});

// writeJsonBody
test(function () {
	$response = Psr7ResponseFactory::fromGlobal();

	$response = $response->writeJsonBody(['foo' => 'bar']);
	Assert::equal(['foo' => 'bar'], $response->getJsonBody());
});

// appendBody
test(function () {
	$response = Psr7ResponseFactory::fromGlobal();
	$response->writeBody('FOO');
	$response->appendBody('BAR');

	Assert::equal('FOOBAR', $response->getContents());
});

// of
test(function () {
	$response = Psr7Response::fromGlobals()
		->withStatus(205)
		->withHeader('X-Foo', 'bar')
		->writeBody('FOOBAR');

	Assert::equal('FOOBAR', $response->getContents());

	$clone = Psr7Response::of($response);

	Assert::equal(205, $clone->getStatusCode());
	Assert::equal('FOOBAR', $clone->getContents());
});

// withAttributes
test(function () {
	$response = Psr7Response::fromGlobals()
		->withHeaders(['X-Foo' => 'bar', 'X-Bar' => 'baz']);

	Assert::equal('bar', $response->getHeaderLine('X-Foo'));
	Assert::equal('baz', $response->getHeaderLine('X-Bar'));
});

// send [exceptions]
test(function () {
	Assert::throws(function () {
		$response = Psr7Response::fromGlobals();
		$response->send();
	}, InvalidStateException::class, 'Cannot send response without Nette\Http\Response');

	Assert::throws(function () {
		$response = Psr7Response::fromGlobals()
			->withHttpResponse(new Response());

		Assert::true($response->hasHttpResponse());
		Assert::type(IResponse::class, $response->getHttpResponse());

		$response->send();
	}, InvalidStateException::class, 'Cannot send response without Nette\Application\Application');
});

// Send
test(function () {
	$response = Psr7Response::fromGlobals()
		->withHttpResponse(new Response())
		->withApplicationResponse(new TextResponse('FOOBAR'));

	Assert::true($response->hasHttpResponse());
	Assert::true($response->hasApplicationResponse());
	Assert::type(IResponse::class, $response->getHttpResponse());
	Assert::type(IApplicationResponse::class, $response->getApplicationResponse());

	$response->send();
});
