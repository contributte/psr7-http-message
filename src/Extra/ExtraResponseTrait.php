<?php declare(strict_types = 1);

namespace Contributte\Psr7\Extra;

use Contributte\Psr7\Psr7Stream;
use JsonSerializable;
use Nette\Utils\Json;

/**
 * @method Psr7Stream getBody()
 */
trait ExtraResponseTrait
{

	/**
	 * @param mixed $body
	 * @return static
	 */
	public function appendBody($body)
	{
		$this->getBody()->write($body);

		return $this;
	}

	/**
	 * @return static
	 */
	public function rewindBody()
	{
		$this->getBody()->rewind();

		return $this;
	}

	/**
	 * @param mixed $body
	 * @return static
	 */
	public function writeBody($body)
	{
		$this->getBody()->write($body);

		return $this;
	}

	/**
	 * @param mixed[] $data
	 * @return static
	 */
	public function writeJsonBody(array $data)
	{
		return $this
			->writeBody(Json::encode($data))
			->withHeader('Content-Type', 'application/json');
	}

	/**
	 * @return static
	 */
	public function writeJsonObject(JsonSerializable $object)
	{
		return $this
			->writeBody(Json::encode($object))
			->withHeader('Content-Type', 'application/json');
	}

	/**
	 * @return mixed
	 */
	public function getJsonBody(bool $assoc = true)
	{
		return Json::decode($this->getContents(), $assoc ? Json::FORCE_ARRAY : 0);
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
