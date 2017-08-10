<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Extra\ExtraRequestTrait;
use Contributte\Psr7\Nette\NetteRequestTrait;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 *
 * @method self|static withAttribute($name, $value)
 * @method self|static withHeader($header, $value)
 */
class Psr7Request extends Request
{

	use ExtraRequestTrait;
	use NetteRequestTrait;

	/**
	 * FACTORY *****************************************************************
	 */

	/**
	 * @param RequestInterface $request
	 * @return static
	 */
	public static function of(RequestInterface $request)
	{
		$new = new static(
			$request->getMethod(),
			$request->getUri(),
			$request->getHeaders(),
			$request->getBody(),
			$request->getProtocolVersion()
		);

		return $new->withRequestTarget($request->getRequestTarget());
	}

}
