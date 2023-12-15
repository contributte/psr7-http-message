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
		// Noop
	}

	/**
	 * @return resource|null
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
	 */
	public function detach()
	{
		$this->close();

		return null;
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
		// Noop
	}

	public function seek(int $offset, int $whence = SEEK_SET): void
	{
		// Noop
	}

	public function eof(): bool
	{
		return true;
	}

	public function tell(): int
	{
		throw new RuntimeException('Null streams cannot tell position');
	}

	public function read(int $length): string
	{
		throw new RuntimeException('Null streams cannot read');
	}

	public function write(string $data): int
	{
		throw new RuntimeException('Null streams cannot write');
	}

	/**
	 * @return null
	 */
	public function getMetadata(?string $key = null)
	{
		return null;
	}

	public function __toString(): string
	{
		return $this->getContents();
	}

}
