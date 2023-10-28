<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte\Psr7\Psr7ResponseFactory;
use Nette\Http\Response;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Test: Psr7ResponseFactory
 *
 * @testCase
 */
class Psr7ResponseFactoryTest extends TestCase
{

	public function testFromGlobal(): void
	{
		$response = Psr7ResponseFactory::fromGlobal();
		$response = $response->withStatus(300);
		Assert::equal(300, $response->getStatusCode());
	}

	public function testFromNette(): void
	{
		$netteResponse = new Response();
		$netteResponse->setCode(300);
		$response = Psr7ResponseFactory::fromNette($netteResponse);
		Assert::equal(300, $response->getStatusCode());
	}

}

(new Psr7ResponseFactoryTest())->run();
