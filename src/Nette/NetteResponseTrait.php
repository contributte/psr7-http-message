<?php declare(strict_types = 1);

namespace Contributte\Psr7\Nette;

use Contributte\Psr7\Exception\Logical\InvalidStateException;
use Nette\Application\Application;
use Nette\Application\IResponse as IApplicationResponse;
use Nette\Http\IResponse as IHttpResponse;
use Nette\Http\RequestFactory;
use Nette\Http\Response;

trait NetteResponseTrait
{

	/** @var IHttpResponse|null */
	protected $httpResponse;

	/** @var IApplicationResponse|null */
	protected $applicationResponse;

	public function getHttpResponse(): ?IHttpResponse
	{
		return $this->httpResponse;
	}

	/**
	 * @return static
	 */
	public function withHttpResponse(IHttpResponse $response)
	{
		$new = clone $this;
		$new->httpResponse = $response;

		return $new;
	}

	public function hasHttpResponse(): bool
	{
		return $this->httpResponse !== null;
	}

	public function getApplicationResponse(): ?IApplicationResponse
	{
		return $this->applicationResponse;
	}

	/**
	 * @return static
	 */
	public function withApplicationResponse(IApplicationResponse $response)
	{
		$new = clone $this;
		$new->applicationResponse = $response;

		return $new;
	}

	public function hasApplicationResponse(): bool
	{
		return $this->applicationResponse !== null;
	}

	/**
	 * FINALIZE ****************************************************************
	 */

	/**
	 * Send whole response
	 */
	public function send(): void
	{
		$this->sendHeaders();
		$this->sendBody();
	}

	/**
	 * Send all headers and status code
	 */
	public function sendHeaders(): void
	{
		if ($this->httpResponse === null) {
			throw new InvalidStateException(sprintf('Cannot send response without %s', Response::class));
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
	 */
	public function sendBody(): void
	{
		if ($this->httpResponse === null) {
			throw new InvalidStateException(sprintf('Cannot send response without %s', Response::class));
		}

		if ($this->applicationResponse === null) {
			throw new InvalidStateException(sprintf('Cannot send response without %s', Application::class));
		}

		$this->applicationResponse->send((new RequestFactory())->fromGlobals(), $this->httpResponse);
	}

}
