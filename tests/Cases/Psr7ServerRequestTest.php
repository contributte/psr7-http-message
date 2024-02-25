<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte\Psr7\Exception\Logical\InvalidStateException;
use Contributte\Psr7\Psr7ServerRequest;
use Contributte\Psr7\Psr7ServerRequestFactory;
use Nette\Http\FileUpload;
use stdClass;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

class Psr7ServerRequestTest extends TestCase
{

	private Psr7ServerRequest $request;

	public function testOf(): void
	{
		$this->request = $this->request
			->withHeader('X-Foo', 'bar')
			->withMethod('PUT');

		Assert::equal('PUT', $this->request->getMethod());

		$clone = Psr7ServerRequest::of($this->request);

		Assert::equal('PUT', $clone->getMethod());
	}

	public function testWithAttributes(): void
	{
		$this->request = $this->request
			->withAttributes(['X-Foo' => 'bar', 'X-Bar' => 'baz']);

		Assert::equal('GET', $this->request->getMethod());
		Assert::equal('bar', $this->request->getAttribute('X-Foo'));
		Assert::equal('baz', $this->request->getAttribute('X-Bar'));
	}

	public function testNormalizeNetteFiles(): void
	{
		$values = [
			'name' => 'foo',
			'size' => 4096,
			'tmp_name' => __DIR__ . '/../Fixtures/bar.txt',
			'error' => UPLOAD_ERR_OK,
		];
		$file1 = new FileUpload($values);
		$file2 = new FileUpload($values);
		$file3 = null;
		$file4 = new FileUpload($values);
		$file5 = null;
		$file6 = new FileUpload($values);

		$passed = [
			$file1,
			[
				$file2,
				$file3,
				$file4,
			],
			$file5,
			$file6,
		];

		Assert::count(4, Psr7ServerRequest::normalizeNetteFiles($passed));
	}

	public function testNormalizeNetteFilesInvalid(): void
	{
		Assert::throws(static function (): void {
			Psr7ServerRequest::normalizeNetteFiles([new stdClass()]);
		}, \InvalidArgumentException::class, 'Invalid value in files specification');
	}

	public function testGetQueryParam(): void
	{
		$_GET['foo'] = 'bar';
		$this->request = Psr7ServerRequestFactory::fromSuperGlobal();

		Assert::true($this->request->hasQueryParam('foo'));
		Assert::equal('bar', $this->request->getQueryParam('foo'));
		Assert::equal('baz', $this->request->getQueryParam('foobar', 'baz'));

		Assert::throws(function (): void {
			$this->request->getQueryParam('baz');
		}, InvalidStateException::class, 'No query parameter "baz" found');
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->request = Psr7ServerRequestFactory::fromGlobal();
	}

}

(new Psr7ServerRequestTest())->run();
