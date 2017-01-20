<?php

namespace Contributte\Psr7;

use GuzzleHttp\Psr7\Response;
use Nette\Application\IResponse as IApplicationResponse;
use Nette\Http\IResponse as IHttpResponse;
use Nette\Http\RequestFactory;
use Nette\InvalidStateException;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Psr7Response extends Response
{

	/** @var IHttpResponse */
	protected $httpResponse;

	/** @var IApplicationResponse */
	protected $applicationResponse;

	/**
	 * @return IHttpResponse
	 */
	public function getHttpResponse()
	{
		return $this->httpResponse;
	}

	/**
	 * @param IHttpResponse $response
	 * @return static
	 */
	public function withHttpResponse(IHttpResponse $response)
	{
		$new = clone $this;
		$new->httpResponse = $response;

		return $new;
	}

	/**
	 * @return bool
	 */
	public function hasHttpResponse()
	{
		return $this->httpResponse !== NULL;
	}

	/**
	 * @return IApplicationResponse
	 */
	public function getApplicationResponse()
	{
		return $this->applicationResponse;
	}

	/**
	 * @param IApplicationResponse $response
	 * @return static
	 */
	public function withApplicationResponse(IApplicationResponse $response)
	{
		$new = clone $this;
		$new->applicationResponse = $response;

		return $new;
	}

	/**
	 * @return bool
	 */
	public function hasApplicationResponse()
	{
		return $this->applicationResponse !== NULL;
	}

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

}
