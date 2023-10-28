<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte\Psr7\Psr7Uri;
use Nette\Http\UrlScript;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Test: Psr7Uri
 *
 * @testCase
 */
class Psr7UriTest extends TestCase
{

	private Psr7Uri $uri;

	public function testWithUrlScript(): void
	{
		$this->uri = $this->uri->withUrlScript(new UrlScript('https://contributte.org'));

		Assert::equal('https://contributte.org/', (string) $this->uri->getUrlScript());
		Assert::equal('https://contributte.org/', $this->uri->getUrlScript()->__toString());
		Assert::equal('https://contributte.org/', $this->uri->getUrlScript()->getAbsoluteUrl());
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->uri = new Psr7Uri();
	}

}

(new Psr7UriTest())->run();
