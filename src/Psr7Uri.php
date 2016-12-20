<?php

namespace Contributte\Psr7;

use GuzzleHttp\Psr7\Uri;
use Nette\Http\UrlScript;

class Psr7Uri extends Uri
{

	/** @var UrlScript */
	protected $urlScript;

	/**
	 * @return UrlScript
	 */
	public function getUrlScript()
	{
		return $this->urlScript;
	}

	/**
	 * @param UrlScript $url
	 * @return static
	 */
	public function withUrlScript(UrlScript $url)
	{
		$new = clone $this;
		$new->urlScript = $url;

		return $new;
	}

}
