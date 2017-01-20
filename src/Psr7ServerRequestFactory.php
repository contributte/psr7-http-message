<?php

namespace Contributte\Psr7;

use Nette\Http\IRequest;
use Nette\Http\RequestFactory;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Psr7ServerRequestFactory
{

	/**
	 * @return Psr7ServerRequest
	 */
	public static function fromSuperGlobal()
	{
		$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : NULL;
		if ($method === 'POST' && isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])
			&& preg_match('#^[A-Z]+\z#', $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])
		) {
			$method = $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];
		}

		$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

		return new Psr7ServerRequest(
			$method,
			$url,
			$_SERVER,
			'php://input',
			$_SERVER
		);
	}

	/**
	 * @return Psr7ServerRequest
	 */
	public static function fromGlobal()
	{
		$requestFactory = new RequestFactory();

		return self::fromNette($requestFactory->createHttpRequest());
	}

	/**
	 * @param IRequest $request
	 * @return Psr7ServerRequest
	 */
	public static function fromNette(IRequest $request)
	{
		$psr7 = new Psr7ServerRequest(
			$request->getMethod(),
			$request->getUrl() ? Psr7UriFactory::fromNette($request->getUrl()) : NULL,
			$request->getHeaders(),
			'php://input',
			$_SERVER
		);

		// Nette-compatibility
		$psr7 = $psr7->withHttpRequest($request);

		return $psr7;
	}

}
