<?php

/**
 * Test: Psr7Request
 */

use Contributte\Psr7\Psr7Request;
use Contributte\Psr7\Psr7RequestFactory;
use Contributte\Psr7\Psr7Uri;
use Nette\Application\Request as ApplicationRequest;
use Nette\Http\RequestFactory;
use Tester\Assert;
use function GuzzleHttp\Psr7\stream_for;

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

// getContents
test(function () {
	$request = Psr7RequestFactory::fromGlobal()
		->withBody(stream_for('FOOBAR'));

	Assert::equal('FOOBAR', $request->getContents());
});

// getJsonBody
test(function () {
	$request = Psr7RequestFactory::fromGlobal()
		->withBody(stream_for(json_encode(['foo' => 'bar'])));

	Assert::equal(['foo' => 'bar'], $request->getJsonBody());
	$request->getBody()->rewind();
	Assert::equal((object) ['foo' => 'bar'], $request->getJsonBody(FALSE));
});

// withNewUri
test(function () {
	$request1 = Psr7RequestFactory::fromGlobal()
		->withUri(new Psr7Uri('https://contributte.org'));

	$request2 = Psr7RequestFactory::fromGlobal()
		->withNewUri('https://contributte.org');

	Assert::equal($request1->getUri(), $request2->getUri());
});

// withHttpRequest
test(function () {
	$httpRequest = (new RequestFactory())->createHttpRequest();

	$request = Psr7RequestFactory::fromGlobal()
		->withHttpRequest($httpRequest)
		->withApplicationRequest(new ApplicationRequest('Foo'));

	Assert::same($httpRequest, $request->getHttpRequest());
	Assert::equal('Foo', $request->getApplicationRequest()->getPresenterName());
});
