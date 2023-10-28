<?php declare(strict_types = 1);

namespace Contributte\Psr7;

use Contributte\Psr7\Extra\ExtraResponseTrait;
use Contributte\Psr7\Nette\NetteResponseTrait;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class Psr7Response extends Response
{

	use ExtraResponseTrait;
	use NetteResponseTrait;

	public static function of(ResponseInterface $response): ResponseInterface
	{
		return new self(
			$response->getStatusCode(),
			$response->getHeaders(),
			$response->getBody(),
			$response->getProtocolVersion(),
			$response->getReasonPhrase()
		);
	}

	public static function fromGlobals(): ResponseInterface
	{
		return new self();
	}

}
