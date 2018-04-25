<?php

namespace Contributte\Psr7\Tests\Helpers;

class JsonObject implements \JsonSerializable
{
	/** @var string */
	private $foo;

	/**
	 * JsonObject constructor.
	 * @param string $foo
	 */
	public function __construct($foo)
	{
		$this->foo = $foo;
	}

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize()
	{
		return ["foo" => $this->foo];
	}
}