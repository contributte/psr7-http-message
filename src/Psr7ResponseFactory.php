<?php

namespace Contributte\Psr7;

use Nette\Http\Response;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Psr7ResponseFactory
{

	/**
	 * @return Psr7Response
	 */
	public static function fromGlobal()
	{
		return new Psr7Response();
	}

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
