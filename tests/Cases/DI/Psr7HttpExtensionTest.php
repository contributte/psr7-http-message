<?php declare(strict_types = 1);

namespace Tests\Cases\DI;

use Contributte\Psr7\DI\Psr7HttpExtension;
use Contributte\Psr7\Psr7Request;
use Contributte\Psr7\Psr7Uri;
use Contributte\Tester\Utils\ContainerBuilder;
use Contributte\Tester\Utils\Neonkit;
use Nette\Bridges\HttpDI\HttpExtension;
use Nette\DI\Compiler;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

class Psr7HttpExtensionTest extends TestCase
{

	public function testGetPsr7RequestService(): void
	{
		$container = ContainerBuilder::of()
			->withCompiler(function (Compiler $compiler): void {
				$compiler->addExtension('psr7', new Psr7HttpExtension());
				$compiler->addExtension('http', new HttpExtension());
				$compiler->addConfig(Neonkit::load(<<<'NEON'
					services:
						http.request: Nette\Http\Request(Nette\Http\UrlScript(https://github.com))
				NEON
				));
			})->build();

		Assert::type(Psr7Request::class, $container->getService('psr7.request'));

		/** @var Psr7Request $psr7Request */
		$psr7Request = $container->getService('psr7.request');
		Assert::type(Psr7Uri::class, $psr7Request->getUri());
		Assert::equal('https://github.com/', (string) $psr7Request->getUri());
	}

}

(new Psr7HttpExtensionTest())->run();
