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

}
