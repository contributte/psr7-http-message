<?php

namespace Contributte\Psr7;

use Nette\Http\IRequest;
use Nette\Http\RequestFactory;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
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
	 * @param IRequest $request
	 * @return Psr7Request
	 */
	public static function fromNette(IRequest $request)
	{
		$psr7 = new Psr7Request(
			$request->getMethod(),
			Psr7UriFactory::fromNette($request->getUrl())
		);

		// Nette-compatibility
		$psr7 = $psr7->withHttpRequest($request);

		return $psr7;
	}

}
