<?php declare(strict_types = 1);

namespace Contributte\Psr7\Extra;

use Contributte\Psr7\Exception\Logical\InvalidStateException;

trait ExtraServerRequestTrait
{

	use ExtraRequestTrait;

	public function hasQueryParam(string $name): bool
	{
		return array_key_exists($name, $this->getQueryParams());
	}

	public function getQueryParam(string $name, mixed $default = null): mixed
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
