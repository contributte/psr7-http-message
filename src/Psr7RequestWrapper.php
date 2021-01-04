<?php declare(strict_types = 1);

namespace Contributte\Psr7;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriInterface;

/**
 * Tiny wrapper for PSR-7 ServerRequestInterface
 */
class Psr7RequestWrapper implements ServerRequestInterface
{

	/** @var ServerRequestInterface */
	protected $inner;

	public function __construct(ServerRequestInterface $request)
	{
		$this->inner = $request;
	}

	public function getOriginalRequest(): ServerRequestInterface
	{
		return $this->inner;
	}

	/**
	 * INTERFACE ***************************************************************
	 */

	public function getProtocolVersion(): string
	{
		return $this->inner->getProtocolVersion();
	}

	/**
	 * @param string $version
	 * @return static
	 */
	public function withProtocolVersion($version): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withProtocolVersion($version);

		return $new;
	}

	/**
	 * @return string[][]
	 */
	public function getHeaders(): array
	{
		return $this->inner->getHeaders();
	}

	/**
	 * @param string $name
	 */
	public function hasHeader($name): bool
	{
		return $this->inner->hasHeader($name);
	}

	/**
	 * @param string $name
	 * @return string[]
	 */
	public function getHeader($name): array
	{
		return $this->inner->getHeader($name);
	}

	/**
	 * @param string $name
	 */
	public function getHeaderLine($name): string
	{
		return $this->inner->getHeaderLine($name);
	}

	/**
	 * @param string          $name
	 * @param string|string[] $value
	 * @return static
	 */
	public function withHeader($name, $value): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withHeader($name, $value);

		return $new;
	}

	/**
	 * @param string          $name
	 * @param string|string[] $value
	 * @return static
	 */
	public function withAddedHeader($name, $value): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withAddedHeader($name, $value);

		return $new;
	}

	/**
	 * @param string $name
	 * @return static
	 */
	public function withoutHeader($name): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withoutHeader($name);

		return $new;
	}

	public function getBody(): StreamInterface
	{
		return $this->inner->getBody();
	}

	/**
	 * @return static
	 */
	public function withBody(StreamInterface $body): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withBody($body);

		return $new;
	}

	public function getRequestTarget(): string
	{
		return $this->inner->getRequestTarget();
	}

	/**
	 * @param mixed $requestTarget
	 * @return static
	 */
	public function withRequestTarget($requestTarget): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withRequestTarget($requestTarget);

		return $new;
	}

	public function getMethod(): string
	{
		return $this->inner->getMethod();
	}

	/**
	 * @param string $method
	 * @return static
	 */
	public function withMethod($method): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withMethod($method);

		return $new;
	}

	public function getUri(): UriInterface
	{
		return $this->inner->getUri();
	}

	/**
	 * @param bool $preserveHost
	 * @return static
	 */
	public function withUri(UriInterface $uri, $preserveHost = false): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withUri($uri, $preserveHost);

		return $new;
	}

	/**
	 * @return mixed[]
	 */
	public function getServerParams(): array
	{
		return $this->inner->getServerParams();
	}

	/**
	 * @return mixed[]
	 */
	public function getCookieParams(): array
	{
		return $this->inner->getCookieParams();
	}

	/**
	 * @param mixed[] $cookies
	 * @return static
	 */
	public function withCookieParams(array $cookies): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withCookieParams($cookies);

		return $new;
	}

	/**
	 * @return mixed[]
	 */
	public function getQueryParams(): array
	{
		return $this->inner->getQueryParams();
	}

	/**
	 * @param mixed[] $query
	 * @return static
	 */
	public function withQueryParams(array $query): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withQueryParams($query);

		return $new;
	}

	/**
	 * @return UploadedFileInterface[]
	 */
	public function getUploadedFiles(): array
	{
		return $this->inner->getUploadedFiles();
	}

	/**
	 * @param UploadedFileInterface[]|mixed[] $uploadedFiles
	 * @return static
	 */
	public function withUploadedFiles(array $uploadedFiles): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withUploadedFiles($uploadedFiles);

		return $new;
	}

	/**
	 * @return mixed[]|object|null
	 */
	public function getParsedBody()
	{
		return $this->inner->getParsedBody();
	}

	/**
	 * @param mixed[]|object|null $data
	 * @return static
	 */
	public function withParsedBody($data): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withParsedBody($data);

		return $new;
	}

	/**
	 * @return mixed[]
	 */
	public function getAttributes(): array
	{
		return $this->inner->getAttributes();
	}

	/**
	 * @see getAttributes()
	 * @param string $name
	 * @param mixed  $default
	 * @return mixed
	 */
	public function getAttribute($name, $default = null)
	{
		return $this->inner->getAttribute($name, $default);
	}

	/**
	 * @see getAttributes()
	 * @param string $name
	 * @param mixed  $value
	 * @return static
	 */
	public function withAttribute($name, $value): self
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
	public function withoutAttribute($name): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withoutAttribute($name);

		return $new;
	}

}
