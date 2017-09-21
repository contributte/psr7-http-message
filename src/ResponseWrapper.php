<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Extra\ExtraResponseTrait;
use Contributte\Psr7\Nette\NetteResponseTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Tiny wrapper for PSR-7 ResponseInterface
 */
class ResponseWrapper implements ResponseInterface
{

	use NetteResponseTrait;
	use ExtraResponseTrait;

	/** @var ResponseInterface */
	protected $inner;

	/**
	 * @param ResponseInterface $inner
	 */
	public function __construct(ResponseInterface $inner)
	{
		$this->inner = $inner;
	}

	/**
	 * @return ResponseInterface
	 */
	public function getOriginalResponse()
	{
		return $this->inner;
	}

	/**
	 * INTERFACE ***************************************************************
	 */

	/**
	 * @return string
	 */
	public function getProtocolVersion()
	{
		return $this->inner->getProtocolVersion();
	}

	/**
	 * @param string $version
	 * @return static
	 */
	public function withProtocolVersion($version)
	{
		$new = clone $this;
		$new->inner = $this->inner->withProtocolVersion($version);

		return $new;
	}

	/**
	 * @return string[][]
	 */
	public function getHeaders()
	{
		return $this->inner->getHeaders();
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasHeader($name)
	{
		return $this->inner->hasHeader($name);
	}

	/**
	 * @param string $name
	 * @return string[]
	 */
	public function getHeader($name)
	{
		return $this->inner->getHeader($name);
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public function getHeaderLine($name)
	{
		return $this->inner->getHeaderLine($name);
	}

	/**
	 * @param string $name
	 * @param string|string[] $value
	 * @return static
	 */
	public function withHeader($name, $value)
	{
		$this->inner = $this->inner->withHeader($name, $value);

		return $this;
	}

	/**
	 * @param string $name
	 * @param string|string[] $value
	 * @return static
	 */
	public function withAddedHeader($name, $value)
	{
		$new = clone $this;
		$new->inner = $this->inner->withAddedHeader($name, $value);

		return $new;
	}

	/**
	 * @param string $name
	 * @return static
	 */
	public function withoutHeader($name)
	{
		$new = clone $this;
		$new->inner = $this->inner->withoutHeader($name);

		return $new;
	}

	/**
	 * @return StreamInterface
	 */
	public function getBody()
	{
		return $this->inner->getBody();
	}

	/**
	 * @param StreamInterface $body
	 * @return static
	 */
	public function withBody(StreamInterface $body)
	{
		$new = clone $this;
		$new->inner = $this->inner->withBody($body);

		return $new;
	}

	/**
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->inner->getStatusCode();
	}

	/**
	 * @param int $code
	 * @param string $reasonPhrase
	 * @return static
	 */
	public function withStatus($code, $reasonPhrase = '')
	{
		$new = clone $this;
		$new->inner = $this->inner->withStatus($code, $reasonPhrase);

		return $new;
	}

	/**
	 * @return string
	 */
	public function getReasonPhrase()
	{
		return $this->inner->getReasonPhrase();
	}

}
