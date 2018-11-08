<?php declare(strict_types = 1);

namespace Contributte\Psr7\Nette;

use Nette\Application\Request as ApplicationRequest;
use Nette\Http\IRequest as HttpRequest;

trait NetteRequestTrait
{

	/** @var HttpRequest */
	protected $httpRequest;

	/** @var ApplicationRequest */
	protected $applicationRequest;

	public function getHttpRequest(): HttpRequest
	{
		return $this->httpRequest;
	}

	/**
	 * @return static
	 */
	public function withHttpRequest(HttpRequest $request)
	{
		$new = clone $this;
		$new->httpRequest = $request;

		return $new;
	}

	public function getApplicationRequest(): ApplicationRequest
	{
		return $this->applicationRequest;
	}

	/**
	 * @return static
	 */
	public function withApplicationRequest(ApplicationRequest $request)
	{
		$new = clone $this;
		$new->applicationRequest = $request;

		return $new;
	}

}
