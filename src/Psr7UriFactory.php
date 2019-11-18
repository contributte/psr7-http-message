<?php declare(strict_types = 1);

namespace Contributte\Psr7;

use Nette\Http\UrlScript;

class Psr7UriFactory
{

	public static function fromNette(UrlScript $url): Psr7Uri
	{
		$uri = $url->getAbsoluteUrl();

		$psr7 = $uri === 'http:///' && PHP_SAPI === 'cli' ? new Psr7Uri() : new Psr7Uri($uri);
		$psr7 = $psr7->withUrlScript($url);

		return $psr7;
	}

}
