<?php

namespace Contributte\Psr7;

use Nette\Http\Request;
use Nette\Http\RequestFactory;

class Psr7RequestFactory
{

	/**
	 * @return Psr7Request
	 */
	public static function fromGlobal()
	{
		$requestFactory = new RequestFactory();

		return self::fromNette($requestFactory->createHttpRequest());
	}

	/**
	 * @param Request $request
	 * @return Psr7Request
	 */
	public static function fromNette(Request $request)
	{
		$psr7 = new Psr7Request(
			$request->getMethod(),
			Psr7UriFactory::fromNette($request->getUrl())
		);

		// Nette-compatibility
		$psr7->withHttpRequest($request);

		return $psr7;
	}

}
