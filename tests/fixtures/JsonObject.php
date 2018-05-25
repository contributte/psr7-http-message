<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use JsonSerializable;

class JsonObject implements JsonSerializable
{

	/** @var string */
	private $foo;

	public function __construct(string $foo)
	{
		$this->foo = $foo;
	}

	/**
	 * Specify data which should be serialized to JSON
	 *
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed[] data which can be serialized by <b>json_encode</b>, which is a value of any type other than a
	 *               resource.
	 */
	public function jsonSerialize(): array
	{
		return ['foo' => $this->foo];
	}

}
