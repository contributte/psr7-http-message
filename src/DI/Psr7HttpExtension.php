<?php

namespace Contributte\Psr7\DI;

use Contributte\Psr7\Psr7ResponseFactory;
use Nette\DI\CompilerExtension;
use Nette\Http\RequestFactory;

class Psr7HttpExtension extends CompilerExtension
{

	/**
	 * Register services
	 *
	 * @return void
	 */
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('requestFactory'))
			->setClass(RequestFactory::class);

		$builder->addDefinition($this->prefix('responseFactory'))
			->setClass(Psr7ResponseFactory::class);
	}

}
