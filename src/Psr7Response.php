<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Exception\Logical\InvalidStateException;
use Contributte\Psr7\Extra\ExtraResponseTrait;
use Contributte\Psr7\Nette\NetteResponseTrait;
use GuzzleHttp\Psr7\Response;
use Nette\Http\RequestFactory;
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
	 * FINALIZE ****************************************************************
	 */

	/**
	 * Send whole response
	 *
	 * @return void
	 */
	public function send()
	{
		$this->sendHeaders();
		$this->sendBody();
	}

	/**
	 * Send all headers and status code
	 *
	 * @return void
	 */
	public function sendHeaders()
	{
		if (!$this->httpResponse) {
			throw new InvalidStateException('Cannot send response without Nette\Http\Response');
		}

		// Send status code
		$this->httpResponse->setCode($this->getStatusCode());

		// Send headers
		foreach ($this->getHeaders() as $name => $values) {
			foreach ($values as $value) {
				$this->httpResponse->setHeader($name, $value);
			}
		}
	}

	/**
	 * Send body
	 *
	 * @return void
	 */
	public function sendBody()
	{
		if (!$this->httpResponse) {
			throw new InvalidStateException('Cannot send response without Nette\Http\Response');
		}

		if (!$this->applicationResponse) {
			throw new InvalidStateException('Cannot send response without Nette\Application\Application');
		}

		$this->applicationResponse->send((new RequestFactory())->createHttpRequest(), $this->httpResponse);
	}

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
