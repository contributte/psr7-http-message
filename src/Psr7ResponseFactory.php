<?php declare(strict_types = 1);

namespace Contributte\Psr7;

use Nette\Http\IResponse;

class Psr7ResponseFactory
{

	public static function fromGlobal(): Psr7Response
	{
		return new Psr7Response();
	}

	public static function fromNette(IResponse $response): Psr7Response
	{
		$psr7 = new Psr7Response();
		$psr7 = $psr7
			->withStatus($response->getCode())
			->withHeaders($response->getHeaders())
			->withHttpResponse($response);

		return $psr7;
	}

}
