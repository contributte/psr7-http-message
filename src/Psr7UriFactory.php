<?php

namespace Contributte\Psr7;

use Nette\Http\UrlScript;

class Psr7UriFactory
{

	/**
	 * @param UrlScript $url
	 * @return Psr7Uri
	 */
	public static function fromNette(UrlScript $url)
	{
		$psr7 = new Psr7Uri((string) $url);
		$psr7 = $psr7->withUrlScript($url);

		return $psr7;
	}

}
