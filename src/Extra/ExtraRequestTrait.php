<?php declare(strict_types = 1);

namespace Contributte\Psr7\Extra;

use Contributte\Psr7\Psr7Stream;
use Contributte\Psr7\Psr7Uri;
use Nette\Utils\Json;

/**
 * @method Psr7Stream getBody()
 */
trait ExtraRequestTrait
{

	public function getContents(): string
	{
		return $this->getBody()->getContents();
	}

	public function getContentsCopy(): string
	{
		$contents = $this->getContents();
		$this->getBody()->rewind();

		return $contents;
	}

	public function getJsonBody(bool $assoc = true): mixed
	{
		return Json::decode($this->getContents(), forceArrays: $assoc);
	}

	public function getJsonBodyCopy(bool $assoc = true): mixed
	{
		$contents = $this->getJsonBody($assoc);
		$this->getBody()->rewind();

		return $contents;
	}

	public function withNewUri(string $uri): static
	{
		return $this->withUri(new Psr7Uri($uri));
	}

}
