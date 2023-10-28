<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte\Psr7\Psr7ServerRequestFactory;
use Nette\Http\FileUpload;
use Nette\Http\Request;
use Nette\Http\UrlScript;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Test: Psr7ServerRequestFactory
 *
 * @testCase
 */
class Psr7ServerRequestFactoryTest extends TestCase
{

	public function testGetUri(): void
	{
		$nette = new Request(
			new UrlScript('https://nette.org')
		);
		$request = Psr7ServerRequestFactory::fromNette($nette);
		Assert::equal('https://nette.org/', $request->getUri()->__toString());
	}

	public function testGetParsedBody(): void
	{
		$nette = new Request(
			new UrlScript('https://nette.org'),
			['foo' => 'bar']
		);
		$request = Psr7ServerRequestFactory::fromNette($nette);
		Assert::equal(['foo' => 'bar'], $request->getParsedBody());
	}

	public function testGetRawBody(): void
	{
		$nette = new Request(
			url: new UrlScript('https://nette.org'),
			rawBodyCallback: static fn () => '{"foo":"bar"}',
		);
		$request = Psr7ServerRequestFactory::fromNette($nette);
		Assert::same('{"foo":"bar"}', (string) $request->getBody());
	}

	public function testUploadedFiles(): void
	{
		file_put_contents(TMP_DIR . '/fake.txt', 'foobar');
		$nette = new Request(
			new UrlScript('https://nette.org'),
			null,
			[new FileUpload(['name' => 'fake.txt', 'type' => 'foo', 'size' => 10, 'tmp_name' => TMP_DIR . '/fake.txt', 'error' => 0])]
		);
		$request = Psr7ServerRequestFactory::fromNette($nette);
		Assert::count(1, $request->getUploadedFiles());
		Assert::equal('fake.txt', $request->getUploadedFiles()[0]->getClientFilename());
		Assert::equal(10, $request->getUploadedFiles()[0]->getSize());
		Assert::equal('text/plain', $request->getUploadedFiles()[0]->getClientMediaType());
		Assert::equal(0, $request->getUploadedFiles()[0]->getError());
	}

	public function testFromGlobal(): void
	{
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$request = Psr7ServerRequestFactory::fromGlobal();
		Assert::equal('POST', $request->getMethod());
	}

	public function testFromSuperGlobal(): void
	{
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$request = Psr7ServerRequestFactory::fromSuperGlobal();
		Assert::equal('POST', $request->getMethod());
	}

}

(new Psr7ServerRequestFactoryTest())->run();
