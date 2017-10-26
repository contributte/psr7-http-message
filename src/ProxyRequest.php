<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Extra\ExtraRequestTrait;
use Contributte\Psr7\Extra\ExtraServerRequestTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * Tiny wrapper for PSR-7 ServerRequestInterface
 */
class ProxyRequest implements ServerRequestInterface
{

	use ExtraRequestTrait;
	use ExtraServerRequestTrait;

	/** @var ServerRequestInterface */
	protected $inner;

	/**
	 * @param ServerRequestInterface $request
	 */
	public function __construct(ServerRequestInterface $request)
	{
		$this->inner = $request;
	}

	/**
	 * @return ServerRequestInterface
	 */
	public function getOriginalRequest()
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
		$new = clone $this;
		$new->inner = $this->inner->withHeader($name, $value);

		return $new;
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
	 * @return string
	 */
	public function getRequestTarget()
	{
		return $this->inner->getRequestTarget();
	}

	/**
	 * @param mixed $requestTarget
	 * @return static
	 */
	public function withRequestTarget($requestTarget)
	{
		$new = clone $this;
		$new->inner = $this->inner->withRequestTarget($requestTarget);

		return $new;
	}

	/**
	 * @return string
	 */
	public function getMethod()
	{
		return $this->inner->getMethod();
	}

	/**
	 * @param string $method
	 * @return static
	 */
	public function withMethod($method)
	{
		$new = clone $this;
		$new->inner = $this->inner->withMethod($method);

		return $new;
	}

	/**
	 * @return UriInterface
	 */
	public function getUri()
	{
		return $this->inner->getUri();
	}

	/**
	 * @param UriInterface $uri
	 * @param bool $preserveHost
	 * @return static
	 */
	public function withUri(UriInterface $uri, $preserveHost = FALSE)
	{
		$new = clone $this;
		$new->inner = $this->inner->withUri($uri, $preserveHost);

		return $new;
	}

	/**
	 * @return array
	 */
	public function getServerParams()
	{
		return $this->inner->getServerParams();
	}

	/**
	 * @return array
	 */
	public function getCookieParams()
	{
		return $this->inner->getCookieParams();
	}

	/**
	 * @param array $cookies
	 * @return static
	 */
	public function withCookieParams(array $cookies)
	{
		$new = clone $this;
		$new->inner = $this->inner->withCookieParams($cookies);

		return $new;
	}

	/**
	 * @return array
	 */
	public function getQueryParams()
	{
		return $this->inner->getQueryParams();
	}

	/**
	 * @param array $query
	 * @return static
	 */
	public function withQueryParams(array $query)
	{
		$new = clone $this;
		$new->inner = $this->inner->withQueryParams($query);

		return $new;
	}

	/**
	 * @return array
	 */
	public function getUploadedFiles()
	{
		return $this->inner->getUploadedFiles();
	}

	/**
	 * @param array $uploadedFiles
	 * @return static
	 */
	public function withUploadedFiles(array $uploadedFiles)
	{
		$new = clone $this;
		$new->inner = $this->inner->withUploadedFiles($uploadedFiles);

		return $new;
	}

	/**
	 * @return null|array|object
	 */
	public function getParsedBody()
	{
		return $this->inner->getParsedBody();
	}

	/**
	 * @param null|array|object $data
	 * @return static
	 */
	public function withParsedBody($data)
	{
		$new = clone $this;
		$new->inner = $this->inner->withParsedBody($data);

		return $new;
	}

	/**
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->inner->getAttributes();
	}

	/**
	 * @see getAttributes()
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getAttribute($name, $default = NULL)
	{
		return $this->inner->getAttribute($name, $default);
	}

	/**
	 * @see getAttributes()
	 * @param string $name
	 * @param mixed $value
	 * @return static
	 */
	public function withAttribute($name, $value)
	{
		$new = clone $this;
		$new->inner = $this->inner->withAttribute($name, $value);

		return $new;
	}

	/**
	 * @see getAttributes()
	 * @param string $name
	 * @return static
	 */
	public function withoutAttribute($name)
	{
		$new = clone $this;
		$new->inner = $this->inner->withoutAttribute($name);

		return $new;
	}

}
