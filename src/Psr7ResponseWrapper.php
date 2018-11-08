<?php declare(strict_types = 1);

namespace Contributte\Psr7;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Tiny wrapper for PSR-7 ResponseInterface
 */
class Psr7ResponseWrapper implements ResponseInterface
{

	/** @var ResponseInterface */
	protected $inner;

	public function __construct(ResponseInterface $inner)
	{
		$this->inner = $inner;
	}

	public function getOriginalResponse(): ResponseInterface
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
		$this->inner = $this->inner->withHeader($name, $value);

		return $this;
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

	public function getStatusCode(): int
	{
		return $this->inner->getStatusCode();
	}

	/**
	 * @param int    $code
	 * @param string $reasonPhrase
	 * @return static
	 */
	public function withStatus($code, $reasonPhrase = ''): self
	{
		$new = clone $this;
		$new->inner = $this->inner->withStatus($code, $reasonPhrase);

		return $new;
	}

	public function getReasonPhrase(): string
	{
		return $this->inner->getReasonPhrase();
	}

}
