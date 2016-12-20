<?php

namespace Contributte\Psr7;

use Nette\Http\Response;

class Psr7ResponseFactory
{

	/**
	 * @param Response $response
	 * @return Psr7Response
	 */
	public static function fromNette(Response $response)
	{
		$psr7 = new Psr7Response();
		$psr7 = $psr7->withHttpResponse($response);

		return $psr7;
	}

}
