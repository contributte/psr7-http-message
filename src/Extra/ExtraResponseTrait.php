<?php declare(strict_types = 1);

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
	 * @return Psr7Response|self
	 */
	public function appendBody($body)
	{
		$this->getBody()->write($body);

		return $this;
	}

	/**
	 * @return Psr7Response|self
	 */
	public function rewindBody()
	{
		$this->getBody()->rewind();

		return $this;
	}

	/**
	 * @param mixed $body
	 * @return Psr7Response|self
	 */
	public function writeBody($body)
	{
		$this->getBody()->write($body);

		return $this;
	}

	/**
	 * @param mixed[] $data
	 * @return Psr7Response|self
	 */
	public function writeJsonBody(array $data)
	{
		return $this
			->writeBody(json_encode($data))
			->withHeader('Content-Type', 'application/json');
	}

	/**
	 * @return Psr7Response|self
	 */
	public function writeJsonObject(JsonSerializable $object)
	{
		return $this
			->writeBody(json_encode($object))
			->withHeader('Content-Type', 'application/json');
	}

	/**
	 * @return mixed
	 */
	public function getJsonBody(bool $assoc = true)
	{
		return json_decode($this->getContents(), $assoc);
	}

	/**
	 * @return mixed
	 */
	public function getContents(bool $rewind = true)
	{
		if ($rewind === true) {
			$this->rewindBody();
		}

		return $this->getBody()->getContents();
	}

	/**
	 * HEADERS ****************************************************************
	 */

	/**
	 * @param string[]|string[][] $headers
	 * @return static
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
