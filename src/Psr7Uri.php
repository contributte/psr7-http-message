<?php declare(strict_types = 1);

namespace Contributte\Psr7;

use GuzzleHttp\Psr7\Uri;
use Nette\Http\UrlScript;

class Psr7Uri extends Uri
{

	/** @var UrlScript */
	protected $urlScript;

	public function getUrlScript(): UrlScript
	{
		return $this->urlScript;
	}

	/**
	 * @return static
	 */
	public function withUrlScript(UrlScript $url): self
	{
		$new = clone $this;
		$new->urlScript = $url;

		return $new;
	}

}
