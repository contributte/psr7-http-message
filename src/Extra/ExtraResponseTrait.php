<?php

namespace Contributte\Psr7\Extra;

use Contributte\Psr7\Psr7Response;
use Contributte\Psr7\Psr7Stream;
use JsonSerializable;

/**
 * @method Psr7Stream getBody()
 */
trait ExtraResponseTrait
{

	/**
	 * @param mixed $body
	 * @return static|Psr7Response
	 */
	public function appendBody($body)
	{
		$this->getBody()->write($body);

		return $this;
	}

	/**
	 * @return static|Psr7Response
	 */
	public function rewindBody()
	{
		$this->getBody()->rewind();

		return $this;
	}

	/**
	 * @param mixed $body
	 * @return static|Psr7Response
	 */
	public function writeBody($body)
	{
		$this->getBody()->write($body);

		return $this;
	}

	/**
	 * @param array $data
	 * @return static|Psr7Response
	 */
	public function writeJsonBody(array $data)
	{
		return $this
			->writeBody(json_encode($data))
			->withHeader('Content-Type', 'application/json');
	}

	/**
	 * @param JsonSerializable $object
	 * @return static|Psr7Response
	 */
	public function writeJsonObject(JsonSerializable $object)
	{
		return $this
			->writeBody(json_encode($object))
			->withHeader('Content-Type', 'application/json');
	}

	/**
	 * @param bool $assoc
	 * @return mixed
	 */
	public function getJsonBody($assoc = TRUE)
	{
		return json_decode($this->getContents(), $assoc);
	}

	/**
	 * @param bool $rewind
	 * @return mixed
	 */
	public function getContents($rewind = TRUE)
	{
		if ($rewind === TRUE) $this->rewindBody();

		return $this->getBody()->getContents();
	}

	/**
	 * HEADERS ****************************************************************
	 */

	/**
	 * @param array $headers
	 * @return static|Psr7Response
	 */
	public function withHeaders(array $headers)
	{
		$new = clone $this;
		foreach ($headers as $key => $value) {
			$new = $new->withHeader($key, $value);
		}

		return $new;
	}

}
