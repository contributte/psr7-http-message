<?php declare(strict_types = 1);

namespace Contributte\Psr7;

use GuzzleHttp\Psr7\Uri;
use Nette\Http\UrlScript;

class Psr7Uri extends Uri
{

	protected UrlScript $urlScript;

	public function getUrlScript(): UrlScript
	{
		return $this->urlScript;
	}

	public function withUrlScript(UrlScript $url): static
	{
		$new = clone $this;
		$new->urlScript = $url;

		return $new;
	}

}
