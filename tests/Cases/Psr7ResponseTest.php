<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte\Psr7\Exception\Logical\InvalidStateException;
use Contributte\Psr7\Psr7Response;
use Nette\Application\Response as ApplicationResponse;
use Nette\Application\Responses\TextResponse;
use Nette\Http\IResponse;
use Nette\Http\Response;
use Tester\Assert;
use Tester\TestCase;
use Tests\Fixtures\JsonObject;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Test: Psr7Response
 *
 * @testCase
 */
class Psr7ResponseTest extends TestCase
{

	private Psr7Response $response;

	public function testGedBody(): void
	{
		$this->response->getBody()->write('foo');
		$this->response->getBody()->write('bar');

		$this->response->getBody()->rewind();
		Assert::equal('foobar', $this->response->getBody()->getContents());
	}

	public function testGetContents(): void
	{
		$this->response->writeBody('FOO');

		Assert::equal('FOO', $this->response->getContents());
	}

	public function testWriteBody(): void
	{
		$this->response->writeBody('FOO');
		Assert::equal('FOO', $this->response->getContents());

		$this->response->writeBody('BAR');
		Assert::equal('FOOBAR', $this->response->getContents());
	}

	public function testWriteJsonBody(): void
	{
		$this->response = $this->response->writeJsonBody(['foo' => 'bar']);
		Assert::equal(['foo' => 'bar'], $this->response->getJsonBody());
	}

	public function testWriteJsonBodyUtf8(): void
	{
		$this->response = $this->response->writeJsonBody(['foo' => 'ěščřžýáíé']);
		Assert::equal(['foo' => 'ěščřžýáíé'], $this->response->getJsonBody());
	}

	public function testWriteJsonObject(): void
	{
		$jsonObject = new JsonObject('bar');
		$this->response = $this->response->writeJsonObject($jsonObject);
		Assert::equal(['foo' => 'bar'], $this->response->getJsonBody());
	}

	public function testWriteJsonObjectUtf8(): void
	{
		$jsonObject = new JsonObject('ěščřžýáíé');
		$this->response = $this->response->writeJsonObject($jsonObject);
		Assert::equal(['foo' => 'ěščřžýáíé'], $this->response->getJsonBody());
	}

	public function testAppendBody(): void
	{
		$this->response->writeBody('FOO');
		$this->response->appendBody('BAR');

		Assert::equal('FOOBAR', $this->response->getContents());
	}

	public function testWithAttributes(): void
	{
		$this->response = $this->response
			->withHeaders(['X-Foo' => 'bar', 'X-Bar' => 'baz']);

		Assert::equal('bar', $this->response->getHeaderLine('X-Foo'));
		Assert::equal('baz', $this->response->getHeaderLine('X-Bar'));
	}

	public function testOf(): void
	{
		$this->response = $this->response
			->withStatus(205)
			->withHeader('X-Foo', 'bar')
			->writeBody('FOOBAR');

		Assert::equal('FOOBAR', $this->response->getContents());

		$clone = Psr7Response::of($this->response);

		Assert::equal(205, $clone->getStatusCode());
		Assert::equal('FOOBAR', $clone->getContents());
	}

	public function testSend(): void
	{
		$this->response = $this->response
			->withHeaders(['X-Foo' => 'Bar'])
			->withHttpResponse(new Response())
			->withApplicationResponse(new TextResponse('FOOBAR'));

		Assert::true($this->response->hasHttpResponse());
		Assert::true($this->response->hasApplicationResponse());
		Assert::type(IResponse::class, $this->response->getHttpResponse());
		Assert::type(ApplicationResponse::class, $this->response->getApplicationResponse());

		$this->response->send();
	}

	public function testSendWithoutHttpResponse(): void
	{
		Assert::throws(function (): void {
			$this->response->send();
		}, InvalidStateException::class, 'Cannot send response without Nette\Http\Response');
	}

	public function testSendWithoutApplication(): void
	{
		Assert::throws(function (): void {
			$this->response = $this->response
				->withHttpResponse(new Response());

			Assert::true($this->response->hasHttpResponse());
			Assert::type(IResponse::class, $this->response->getHttpResponse());

			$this->response->send();
		}, InvalidStateException::class, 'Cannot send response without Nette\Application\Application');
	}

	public function testSendBodyWithoutHttpResponse(): void
	{
		Assert::throws(function (): void {
			$this->response->sendBody();
		}, InvalidStateException::class, 'Cannot send response without Nette\Http\Response');
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->response = Psr7Response::fromGlobals();
	}

}

(new Psr7ResponseTest())->run();
