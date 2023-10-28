<?php declare(strict_types = 1);

namespace Contributte\Psr7\Nette;

use Contributte\Psr7\Exception\Logical\InvalidStateException;
use Nette\Application\Application;
use Nette\Application\Response as ApplicationResponse;
use Nette\Http\IResponse as HttpResponse;
use Nette\Http\RequestFactory;
use Nette\Http\Response;

trait NetteResponseTrait
{

	protected ?HttpResponse $httpResponse = null;

	protected ?ApplicationResponse $applicationResponse = null;

	public function getHttpResponse(): ?HttpResponse
	{
		return $this->httpResponse;
	}

	public function withHttpResponse(HttpResponse $response): static
	{
		$new = clone $this;
		$new->httpResponse = $response;

		return $new;
	}

	public function hasHttpResponse(): bool
	{
		return $this->httpResponse !== null;
	}

	public function getApplicationResponse(): ?ApplicationResponse
	{
		return $this->applicationResponse;
	}

	public function withApplicationResponse(ApplicationResponse $response): static
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
