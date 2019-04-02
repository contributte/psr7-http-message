<?php declare(strict_types = 1);

namespace Contributte\Psr7;

use Contributte\Psr7\Extra\ExtraRequestTrait;
use Contributte\Psr7\Nette\NetteRequestTrait;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class Psr7Request extends Request
{

	use ExtraRequestTrait;
	use NetteRequestTrait;

	/**
	 * FACTORY *****************************************************************
	 */

	/**
	 * @return static
	 */
	public static function of(RequestInterface $request): self
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
