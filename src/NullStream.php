<?php

namespace Contributte\Psr7;

use Psr\Http\Message\StreamInterface;
use RuntimeException;

class NullStream implements StreamInterface
{

	/**
	 * @return null
	 */
	public function getContents()
	{
		return NULL;
	}

	/**
	 * @return void
	 */
	public function close()
	{
	}

	/**
	 * @return void
	 */
	public function detach()
	{
		$this->close();
	}

	/**
	 * @return int
	 */
	public function getSize()
	{
		return 0;
	}

	/**
	 * @return bool
	 */
	public function isReadable()
	{
		return FALSE;
	}

	/**
	 * @return bool
	 */
	public function isWritable()
	{
		return FALSE;
	}

	/**
	 * @return bool
	 */
	public function isSeekable()
	{
		return FALSE;
	}

	/**
	 * @return void
	 */
	public function rewind()
	{
	}

	/**
	 * @param int $offset
	 * @param int $whence
	 * @return void
	 */
	public function seek($offset, $whence = SEEK_SET)
	{
	}

	/**
	 * @return bool
	 */
	public function eof()
	{
		return TRUE;
	}

	/**
	 * @return void
	 */
	public function tell()
	{
		throw new RuntimeException('Null streams cannot tell position');
	}

	/**
	 * @param int $length
	 * @return void
	 */
	public function read($length)
	{
		throw new RuntimeException('Null streams cannot read');
	}

	/**
	 * @param mixed $data
	 * @return void
	 */
	public function write($data)
	{
		throw new RuntimeException('Null streams cannot write');
	}

	/**
	 * @param string $key
	 * @return null
	 */
	public function getMetadata($key = NULL)
	{
		return NULL;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->getContents();
	}

}
