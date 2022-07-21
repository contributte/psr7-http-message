<?php declare(strict_types = 1);

/**
 * Test: ProxyResponse
 */

use Contributte\Psr7\ProxyResponse;
use Contributte\Psr7\Psr7ResponseFactory;
use GuzzleHttp\Psr7\Utils;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// withProtocolVersion
test(function (): void {
	$response = Psr7ResponseFactory::fromGlobal();

	$proxy = new ProxyResponse($response);

	$modifiedProxy = $proxy->withProtocolVersion('1.1');
	Assert::equal('1.1', $modifiedProxy->getProtocolVersion());

	Assert::same($response, $proxy->getOriginalResponse());
});

// withHeader
test(function (): void {
	$response = Psr7ResponseFactory::fromGlobal();

	$proxy = new ProxyResponse($response);

	$modifiedProxy = $proxy->withHeader('Content-Type', 'application/json');

	Assert::true($modifiedProxy->hasHeader('Content-Type'));
	Assert::same(['application/json'], $modifiedProxy->getHeader('Content-Type'));
	Assert::same(['Content-Type' => ['application/json']], $modifiedProxy->getHeaders());

	Assert::same($response, $proxy->getOriginalResponse());
});

// withBody
test(function (): void {
	$response = Psr7ResponseFactory::fromGlobal();

	$proxy = new ProxyResponse($response);

	Assert::same(
		'foo',
		$proxy->withBody(Utils::streamFor('foo'))->getContents()
	);

	Assert::same($response, $proxy->getOriginalResponse());
});

// withStatus
test(function (): void {
	$response = Psr7ResponseFactory::fromGlobal();

	$proxy = new ProxyResponse($response);

	$modifiedProxy = $proxy->withStatus(200);

	Assert::same(200, $modifiedProxy->getStatusCode());
	Assert::same('OK', $modifiedProxy->getReasonPhrase());

	Assert::same($response, $proxy->getOriginalResponse());
});
