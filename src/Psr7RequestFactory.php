<?php

namespace Contributte\Psr7;

use GuzzleHttp\Psr7\LazyOpenStream;
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
			$request->getUrl() ? Psr7UriFactory::fromNette($request->getUrl()) : NULL,
			$request->getHeaders(),
			new LazyOpenStream('php://input', 'r+'),
			str_replace('HTTP/', '', $request->getHeader('SERVER_PROTOCOL', '1.1'))
		);

		// Nette-compatibility
		$psr7 = $psr7->withHttpRequest($request);

		return $psr7;
	}

}
