<?php declare(strict_types = 1);

namespace Tests\Cases\Bridge;

use Contributte\Psr7\Bridge\Psr7Response;
use Contributte\Psr7\Psr7Response as Psr7MessageResponse;
use Contributte\Tester\Utils\Httpkit;
use Nette\Http\Request;
use Nette\Http\Response;
use Nette\Http\UrlScript;
use Psr\Http\Message\ResponseInterface;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

class Psr7ResponseTest extends TestCase
{

	public function testGetResponse(): void
	{
		$psr7Response = Psr7MessageResponse::fromGlobals();
		$response = new Psr7Response($psr7Response);

		Assert::type(ResponseInterface::class, $response->getResponse());
		Assert::same($psr7Response, $response->getResponse());
	}

	public function testSend(): void
	{
		$psr7Response = Psr7MessageResponse::fromGlobals()
			->withStatus(201)
			->withHeader('X-Custom', 'test-value')
			->withHeader('Content-Type', 'application/json');

		$psr7Response->getBody()->write('{"foo":"bar"}');

		$response = new Psr7Response($psr7Response);

		$httpRequest = new Request(new UrlScript('https://example.com'));
		$httpResponse = new Response();

		Httpkit::wrap(function () use ($response, $httpRequest, $httpResponse): void {
			ob_start();
			$response->send($httpRequest, $httpResponse);
			$output = ob_get_clean();

			Assert::equal('{"foo":"bar"}', $output);
		});

		Assert::equal(201, $httpResponse->getCode());
	}

	public function testSendWithEmptyBody(): void
	{
		$psr7Response = Psr7MessageResponse::fromGlobals()
			->withStatus(204);

		$response = new Psr7Response($psr7Response);

		$httpRequest = new Request(new UrlScript('https://example.com'));
		$httpResponse = new Response();

		Httpkit::wrap(function () use ($response, $httpRequest, $httpResponse): void {
			ob_start();
			$response->send($httpRequest, $httpResponse);
			$output = ob_get_clean();

			Assert::equal('', $output);
		});

		Assert::equal(204, $httpResponse->getCode());
	}

	public function testSendWithMultipleHeaders(): void
	{
		$psr7Response = Psr7MessageResponse::fromGlobals()
			->withStatus(200)
			->withHeader('X-First', 'first')
			->withHeader('X-Second', 'second');

		$psr7Response->getBody()->write('content');

		$response = new Psr7Response($psr7Response);

		$httpRequest = new Request(new UrlScript('https://example.com'));
		$httpResponse = new Response();

		Httpkit::wrap(function () use ($response, $httpRequest, $httpResponse): void {
			ob_start();
			$response->send($httpRequest, $httpResponse);
			ob_end_clean();
		});

		Assert::equal(200, $httpResponse->getCode());
	}

}

(new Psr7ResponseTest())->run();
