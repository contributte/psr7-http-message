<?php

namespace Contributte\Psr7;

use Nette\Http\IResponse;

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
	 * @param IResponse $response
	 * @return Psr7Response
	 */
	public static function fromNette(IResponse $response)
	{
		$psr7 = new Psr7Response();
		$psr7 = $psr7
			->withStatus($response->getCode())
			->withHeaders($response->getHeaders())
			->withHttpResponse($response);

		return $psr7;
	}

}
