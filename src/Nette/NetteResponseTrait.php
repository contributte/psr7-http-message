<?php

namespace Contributte\Psr7\Nette;

use Nette\Application\IResponse as IApplicationResponse;
use Nette\Http\IResponse as IHttpResponse;

trait NetteResponseTrait
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

}
