<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Nette\NetteResponseTrait;
use GuzzleHttp\Psr7\Response;
use Nette\Http\RequestFactory;
use Nette\InvalidStateException;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 *
 * @method self withHeader($header, $value)
 */
class Psr7Response extends Response
{

	use NetteResponseTrait;

	/**
	 * @param mixed $body
	 * @return static
	 */
	public function appendBody($body)
	{
		$this->getBody()->write($body);

		return $this;
	}

	/**
	 * @param mixed $body
	 * @param bool $clear
	 * @return static
	 */
	public function setBody($body, $clear = TRUE)
	{
		if ($clear === TRUE) $this->rewindBody();
		$this->getBody()->write($body);

		return $this;
	}

	/**
	 * @return static
	 */
	public function rewindBody()
	{
		$this->getBody()->rewind();

		return $this;
	}

	/**
	 * @param mixed $body
	 * @return static
	 */
	public function writeBody($body)
	{
		$this->getBody()->write($body);

		return $this;
	}

	/**
	 * @param bool $rewind
	 * @return mixed
	 */
	public function getContents($rewind = TRUE)
	{
		if ($rewind === TRUE) $this->rewindBody();

		return $this->getBody()->getContents();
	}

	/**
	 * HEADERS ****************************************************************
	 */

	/**
	 * @param array $headers
	 * @return static
	 */
	public function withHeaders(array $headers)
	{
		$new = clone $this;
		foreach ($headers as $key => $value) {
			$new = $new->withHeader($key, $value);
		}

		return $new;
	}

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
