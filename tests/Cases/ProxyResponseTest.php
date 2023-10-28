<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte\Psr7\ProxyResponse;
use Contributte\Psr7\Psr7Response;
use Contributte\Psr7\Psr7ResponseFactory;
use GuzzleHttp\Psr7\Utils;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Test: ProxyResponse
 *
 * @testCase
 */
class ProxyResponseTest extends TestCase
{

	private const HEADER = 'Content-Type';

	private ProxyResponse $proxy;

	private Psr7Response $response;

	public function testWithProtocolVersion(): void
	{
		$modifiedProxy = $this->proxy->withProtocolVersion('1.1');

		Assert::equal('1.1', $modifiedProxy->getProtocolVersion());

		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	public function testWithHeader(): void
	{
		$modifiedProxy = $this->proxy->withHeader(self::HEADER, 'application/json');

		Assert::true($modifiedProxy->hasHeader(self::HEADER));
		Assert::same(['application/json'], $modifiedProxy->getHeader(self::HEADER));
		Assert::same([self::HEADER => ['application/json']], $modifiedProxy->getHeaders());
		Assert::same('application/json', $modifiedProxy->getHeaderLine(self::HEADER));

		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	public function testWithAddedHeader(): void
	{
		$modifiedProxy = $this->proxy->withAddedHeader(self::HEADER, 'application/json');

		Assert::true($modifiedProxy->hasHeader(self::HEADER));
		Assert::same(['application/json'], $modifiedProxy->getHeader(self::HEADER));
		Assert::same([self::HEADER => ['application/json']], $modifiedProxy->getHeaders());
		Assert::same('application/json', $modifiedProxy->getHeaderLine(self::HEADER));

		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	public function testWithoutHeader(): void
	{
		$modifiedProxy = $this->proxy->withHeader(self::HEADER, 'application/json');

		Assert::true($modifiedProxy->hasHeader(self::HEADER));
		Assert::same(['application/json'], $modifiedProxy->getHeader(self::HEADER));
		Assert::same([self::HEADER => ['application/json']], $modifiedProxy->getHeaders());
		Assert::same('application/json', $modifiedProxy->getHeaderLine(self::HEADER));

		$modifiedProxy = $modifiedProxy->withoutHeader(self::HEADER);

		Assert::false($modifiedProxy->hasHeader(self::HEADER));
		Assert::same([], $modifiedProxy->getHeader(self::HEADER));
		Assert::same([], $modifiedProxy->getHeaders());
		Assert::same('', $modifiedProxy->getHeaderLine(self::HEADER));

		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	public function testWithBody(): void
	{
		Assert::same(
			'foo',
			$this->proxy->withBody(Utils::streamFor('foo'))->getContents()
		);

		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	public function testWithStatus(): void
	{
		$modifiedProxy = $this->proxy->withStatus(200);

		Assert::same(200, $modifiedProxy->getStatusCode());
		Assert::same('OK', $modifiedProxy->getReasonPhrase());

		Assert::same($this->response, $this->proxy->getOriginalResponse());
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->response = Psr7ResponseFactory::fromGlobal();
		$this->proxy = new ProxyResponse($this->response);
	}

}

(new ProxyResponseTest())->run();
