<?php

namespace Contributte\Psr7;

use Nette\Application\Request as ApplicationRequest;
use Nette\Http\IRequest as HttpRequest;

trait NetteRequestTrait
{

	/** @var HttpRequest */
	protected $httpRequest;

	/** @var ApplicationRequest */
	protected $applicationRequest;

	/**
	 * @return HttpRequest
	 */
	public function getHttpRequest()
	{
		return $this->httpRequest;
	}

	/**
	 * @param HttpRequest $request
	 * @return static
	 */
	public function withHttpRequest(HttpRequest $request)
	{
		$new = clone $this;
		$new->httpRequest = $request;

		return $new;
	}

	/**
	 * @return ApplicationRequest
	 */
	public function getApplicationRequest()
	{
		return $this->applicationRequest;
	}

	/**
	 * @param ApplicationRequest $request
	 * @return static
	 */
	public function withApplicationRequest(ApplicationRequest $request)
	{
		$new = clone $this;
		$new->applicationRequest = $request;

		return $new;
	}

}
