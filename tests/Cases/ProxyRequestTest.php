<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte\Psr7\ProxyRequest;
use Contributte\Psr7\Psr7ServerRequest;
use Contributte\Psr7\Psr7ServerRequestFactory;
use GuzzleHttp\Psr7\Utils;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Test: ProxyRequest
 *
 * @testCase
 */
class ProxyRequestTest extends TestCase
{

	private const HEADER = 'Content-Type';

	private ProxyRequest $proxy;

	private Psr7ServerRequest $request;

	public function testWithProtocolVersion(): void
	{
		$modifiedProxy = $this->proxy->withProtocolVersion('1.1');

		Assert::equal('1.1', $modifiedProxy->getProtocolVersion());

		Assert::same($this->request, $this->proxy->getOriginalRequest());
	}

	public function testWithHeader(): void
	{
		$modifiedProxy = $this->proxy->withHeader(self::HEADER, 'application/json');

		Assert::true($modifiedProxy->hasHeader(self::HEADER));
		Assert::same(['application/json'], $modifiedProxy->getHeader(self::HEADER));
		Assert::same([self::HEADER => ['application/json']], $modifiedProxy->getHeaders());
		Assert::same('application/json', $modifiedProxy->getHeaderLine(self::HEADER));

		Assert::same($this->request, $this->proxy->getOriginalRequest());
	}

	public function testWithAddedHeader(): void
	{
		$modifiedProxy = $this->proxy->withAddedHeader(self::HEADER, 'application/json');

		Assert::true($modifiedProxy->hasHeader(self::HEADER));
		Assert::same(['application/json'], $modifiedProxy->getHeader(self::HEADER));
		Assert::same([self::HEADER => ['application/json']], $modifiedProxy->getHeaders());
		Assert::same('application/json', $modifiedProxy->getHeaderLine(self::HEADER));

		Assert::same($this->request, $this->proxy->getOriginalRequest());
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

		Assert::same($this->request, $this->proxy->getOriginalRequest());
	}

	public function testWithBody(): void
	{
		Assert::same(
			'foo',
			$this->proxy->withBody(Utils::streamFor('foo'))->getContents()
		);

		Assert::same($this->request, $this->proxy->getOriginalRequest());
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->request = Psr7ServerRequestFactory::fromGlobal();
		$this->proxy = new ProxyRequest($this->request);
	}

}

(new ProxyRequestTest())->run();
