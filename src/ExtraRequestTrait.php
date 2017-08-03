<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Exception\Logical\InvalidStateException;

trait ExtraRequestTrait
{

	/**
	 * BODY ********************************************************************
	 */

	/**
	 * @return mixed
	 */
	public function getContents()
	{
		return $this->getBody()->getContents();
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
	 * URI *********************************************************************
	 */

	/**
	 * @param string $uri
	 * @return static
	 */
	public function withNewUri($uri)
	{
		return $this->withUri(new Psr7Uri($uri));
	}

	/**
	 * QUERY PARAM *************************************************************
	 */

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function hasQueryParam($name)
	{
		return array_key_exists($name, $this->getQueryParams());
	}

	/**
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getQueryParam($name, $default = NULL)
	{
		if (!$this->hasQueryParam($name)) {
			if (func_num_args() < 2) {
				throw new InvalidStateException(sprintf('No query parameter "%s" found', $name));
			}

			return $default;
		}

		return $this->getQueryParams()[$name];
	}

}
