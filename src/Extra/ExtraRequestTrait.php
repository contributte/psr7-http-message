<?php

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
	 * @deprecated
	 */
	public function getBodyClone()
	{
		trigger_error('This method is deprecated', E_DEPRECATED);

		return clone $this->getBody();
	}

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
	 * @param bool $assoc
	 * @return mixed
	 */
	public function getJsonBody($assoc = TRUE)
	{
		return json_decode((string) $this->getBody(), $assoc);
	}

	/**
	 * @param bool $assoc
	 * @return mixed
	 */
	public function getJsonBodyCopy($assoc = TRUE)
	{
		$contents = $this->getJsonBody($assoc);
		$this->getBody()->rewind();

		return $contents;
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

}
