<?php declare(strict_types = 1);

namespace Contributte\Psr7;

use Psr\Http\Message\StreamInterface;
use RuntimeException;

class NullStream implements StreamInterface
{

	public function getContents(): string
	{
		return '';
	}

	public function close(): void
	{
	}

	public function detach(): void
	{
		$this->close();
	}

	public function getSize(): int
	{
		return 0;
	}

	public function isReadable(): bool
	{
		return false;
	}

	public function isWritable(): bool
	{
		return false;
	}

	public function isSeekable(): bool
	{
		return false;
	}

	public function rewind(): void
	{
	}

	/**
	 * @param int $offset
	 * @param int $whence
	 */
	public function seek($offset, $whence = SEEK_SET): void
	{
	}

	public function eof(): bool
	{
		return true;
	}

	public function tell(): void
	{
		throw new RuntimeException('Null streams cannot tell position');
	}

	/**
	 * @param int $length
	 */
	public function read($length): void
	{
		throw new RuntimeException('Null streams cannot read');
	}

	/**
	 * @param mixed $data
	 */
	public function write($data): void
	{
		throw new RuntimeException('Null streams cannot write');
	}

	/**
	 * @param string|null $key
	 * @return null
	 */
	public function getMetadata($key = null)
	{
		return null;
	}

	public function __toString(): string
	{
		return $this->getContents();
	}

}
