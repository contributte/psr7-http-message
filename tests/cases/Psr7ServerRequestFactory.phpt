<?php declare(strict_types = 1);

/**
 * Test: Psr7ServerRequestFactory
 */

use Contributte\Psr7\Psr7ServerRequestFactory;
use Nette\Http\FileUpload;
use Nette\Http\Request;
use Nette\Http\UrlScript;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// Uri
test(function (): void {
	$nette = new Request(
		new UrlScript('https://nette.org')
	);
	$request = Psr7ServerRequestFactory::fromNette($nette);
	Assert::equal('https://nette.org/', $request->getUri()->__toString());
});

// ParsedBody
test(function (): void {
	$nette = new Request(
		new UrlScript('https://nette.org'),
		null,
		['foo' => 'bar']
	);
	$request = Psr7ServerRequestFactory::fromNette($nette);
	Assert::equal(['foo' => 'bar'], $request->getParsedBody());
});

// RawBody
test(function (): void {
	$nette = new Request(
		new UrlScript('https://nette.org'),
		null,
		null,
		null,
		null,
		null,
		null,
		null,
		null,
		function () {
			return '{"foo":"bar"}';
		}
	);
	$request = Psr7ServerRequestFactory::fromNette($nette);
	Assert::same('{"foo":"bar"}', (string) $request->getBody());
});

// Global
test(function (): void {
	$_SERVER['REQUEST_METHOD'] = 'POST';
	$request = Psr7ServerRequestFactory::fromGlobal();
	Assert::equal('POST', $request->getMethod());
});

// SuperGlobal
test(function (): void {
	$_SERVER['REQUEST_METHOD'] = 'POST';
	$request = Psr7ServerRequestFactory::fromSuperGlobal();
	Assert::equal('POST', $request->getMethod());
});

// FileUpload
test(function (): void {
	file_put_contents(TMP_DIR . '/fake.txt', 'foobar');
	$nette = new Request(
		new UrlScript('https://nette.org'),
		null,
		null,
		[new FileUpload(['name' => 'fake.txt', 'type' => 'foo', 'size' => 10, 'tmp_name' => TMP_DIR . '/fake.txt', 'error' => 0])]
	);
	$request = Psr7ServerRequestFactory::fromNette($nette);
	Assert::count(1, $request->getUploadedFiles());
	Assert::equal('fake.txt', $request->getUploadedFiles()[0]->getClientFilename());
	Assert::equal(10, $request->getUploadedFiles()[0]->getSize());
	Assert::equal('text/plain', $request->getUploadedFiles()[0]->getClientMediaType());
	Assert::equal(0, $request->getUploadedFiles()[0]->getError());
});
