<?php declare(strict_types = 1);

namespace Contributte\Psr7\Extra;

use Contributte\Psr7\Psr7Stream;
use Contributte\Psr7\Psr7Uri;

/**
 * @method Psr7Stream getBody()
 */
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
	 * @return mixed
	 */
	public function getContentsCopy()
	{
		$contents = $this->getContents();
		$this->getBody()->rewind();

		return $contents;
	}

	/**
	 * @return mixed
	 */
	public function getJsonBody(bool $assoc = true)
	{
		return json_decode((string) $this->getBody(), $assoc);
	}

	/**
	 * @return mixed
	 */
	public function getJsonBodyCopy(bool $assoc = true)
	{
		$contents = $this->getJsonBody($assoc);
		$this->getBody()->rewind();

		return $contents;
	}

	/**
	 * URI *********************************************************************
	 */

	public function withNewUri(string $uri): self
	{
		return $this->withUri(new Psr7Uri($uri));
	}

}
