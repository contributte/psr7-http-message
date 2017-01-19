<?php

namespace Contributte\Psr7;

use Nette\Http\UrlScript;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Psr7UriFactory
{

	/**
	 * @param UrlScript $url
	 * @return Psr7Uri
	 */
	public static function fromNette(UrlScript $url)
	{
		$uri = (string) $url;

		if ($uri === 'http:///' && PHP_SAPI === 'cli') {
			$psr7 = new Psr7Uri();
		} else {
			$psr7 = new Psr7Uri($uri);
		}

		$psr7 = $psr7->withUrlScript($url);

		return $psr7;
	}

}
