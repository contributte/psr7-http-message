<?php

namespace Contributte\Psr7;

use Nette\Http\IRequest;
use Nette\Http\RequestFactory;
use function GuzzleHttp\Psr7\stream_for;

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
			stream_for($request->getRawBody()),
			str_replace('HTTP/', '', $request->getHeader('SERVER_PROTOCOL', '1.1'))
		);

		// Nette-compatibility
		$psr7 = $psr7->withHttpRequest($request);

		return $psr7;
	}

}
