<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte\Psr7\Psr7Request;
use Contributte\Psr7\Psr7RequestFactory;
use Contributte\Psr7\Psr7Uri;
use GuzzleHttp\Psr7\Utils;
use Nette\Application\Request as ApplicationRequest;
use Nette\Http\RequestFactory;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Test: Psr7Request
 *
 * @testCase
 */
class Psr7RequestTest extends TestCase
{

	private Psr7Request $request;

	public function testOf(): void
	{
		$this->request = $this->request
			->withHeader('X-Foo', 'bar')
			->withMethod('PUT');

		Assert::equal('PUT', $this->request->getMethod());

		$clone = Psr7Request::of($this->request);

		Assert::equal('PUT', $clone->getMethod());
	}

	public function testGetContents(): void
	{
		$this->request = $this->request
			->withBody(Utils::streamFor('FOOBAR'));

		Assert::equal('FOOBAR', $this->request->getContents());
		Assert::equal('', $this->request->getContents());
	}

	public function testGetContentsCopy(): void
	{
		$this->request = $this->request
			->withBody(Utils::streamFor('FOOBAR'));

		Assert::equal('FOOBAR', $this->request->getContentsCopy());
		Assert::equal('FOOBAR', $this->request->getContentsCopy());
	}

	public function testGetJsonBody(): void
	{
		$this->request = $this->request
			->withBody(Utils::streamFor(json_encode(['foo' => 'bar'])));

		Assert::equal(['foo' => 'bar'], $this->request->getJsonBody());
		$this->request->getBody()->rewind();
		Assert::equal((object) ['foo' => 'bar'], $this->request->getJsonBody(false));
	}

	public function testGetJsonBodyCopy(): void
	{
		$this->request = $this->request
			->withBody(Utils::streamFor(json_encode(['foo' => 'bar'])));

		Assert::equal(['foo' => 'bar'], $this->request->getJsonBodyCopy());
		$this->request->getBody()->rewind();
		Assert::equal((object) ['foo' => 'bar'], $this->request->getJsonBodyCopy(false));
	}

	public function testWithNewUri(): void
	{
		$uri = 'https://contributte.org';
		$this->request = $this->request->withNewUri($uri);
		Assert::equal(new Psr7Uri($uri), $this->request->getUri());
	}

	public function testWithUri(): void
	{
		$uri = new Psr7Uri('https://contributte.org');
		$this->request = $this->request->withUri($uri);
		Assert::same($uri, $this->request->getUri());
	}

	public function testWithHttpRequest(): void
	{
		$httpRequest = (new RequestFactory())->fromGlobals();

		$this->request = $this->request
			->withHttpRequest($httpRequest)
			->withApplicationRequest(new ApplicationRequest('Foo'));

		Assert::same($httpRequest, $this->request->getHttpRequest());
		Assert::equal('Foo', $this->request->getApplicationRequest()->getPresenterName());
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->request = Psr7RequestFactory::fromGlobal();
	}

}

(new Psr7RequestTest())->run();
