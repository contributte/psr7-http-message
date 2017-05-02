<?php

namespace Contributte\Psr7;

use GuzzleHttp\Psr7\LazyOpenStream;
use Nette\Http\IRequest;
use Nette\Http\RequestFactory;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Psr7ServerRequestFactory
{

	/**
	 * @return Psr7ServerRequest|ServerRequestInterface
	 */
	public static function fromSuperGlobal()
	{
		return Psr7ServerRequest::fromGlobals();
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
			new LazyOpenStream('php://input', 'r+'),
			str_replace('HTTP/', '', $request->getHeader('SERVER_PROTOCOL', '1.1')),
			$_SERVER
		);

		$psr7 = $psr7->withCookieParams($request->getCookies())
			->withQueryParams($request->getQuery())
			->withParsedBody($request->getPost())
			->withUploadedFiles(Psr7ServerRequest::normalizeNetteFiles($request->getFiles()));

		// Nette-compatibility
		$psr7 = $psr7->withHttpRequest($request);

		return $psr7;
	}

}
