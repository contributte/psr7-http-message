<?php

namespace Contributte\Psr7\Extra;

use Contributte\Psr7\Exception\Logical\InvalidStateException;

trait ExtraServerRequestTrait
{

	use ExtraRequestTrait;

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
