<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Extra\ExtraResponseTrait;
use Contributte\Psr7\Nette\NetteResponseTrait;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 *
 * @method static withHeader($header, $value)
 */
class Psr7Response extends Response
{

	use ExtraResponseTrait;
	use NetteResponseTrait;

	/**
	 * FACTORY *****************************************************************
	 */

	/**
	 * @param ResponseInterface $response
	 * @return static
	 */
	public static function of(ResponseInterface $response)
	{
		return new static(
			$response->getStatusCode(),
			$response->getHeaders(),
			$response->getBody(),
			$response->getProtocolVersion(),
			$response->getReasonPhrase()
		);
	}

	/**
	 * @return static
	 */
	public static function fromGlobals()
	{
		return new static();
	}

}
