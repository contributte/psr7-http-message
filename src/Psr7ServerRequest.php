<?php declare(strict_types = 1);

namespace Contributte\Psr7;

use Contributte\Psr7\Extra\ExtraServerRequestTrait;
use Contributte\Psr7\Nette\NetteRequestTrait;
use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\ServerRequest;
use InvalidArgumentException;
use Nette\Http\FileUpload;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @method Psr7UploadedFile[] getUploadedFiles()
 */
class Psr7ServerRequest extends ServerRequest
{

	use NetteRequestTrait;
	use ExtraServerRequestTrait;

	/**
	 * @param FileUpload[]|FileUpload[][]|mixed[]|mixed[][] $files
	 * @return Psr7UploadedFile[]
	 */
	public static function normalizeNetteFiles(array $files): array
	{
		$normalized = [];

		foreach ($files as $file) {
			if ($file instanceof FileUpload) {
				$normalized[] = new Psr7UploadedFile(
					$file->getTemporaryFile(),
					$file->getSize(),
					$file->getError(),
					$file->getUntrustedName(),
					$file->getContentType()
				);
			} elseif (is_array($file)) {
				$normalized = array_merge($normalized, self::normalizeNetteFiles($file));
			} elseif ($file === null) {
				continue;
			} else {
				throw new InvalidArgumentException('Invalid value in files specification');
			}
		}

		return $normalized;
	}

	public static function of(ServerRequestInterface $request): ServerRequestInterface
	{
		$new = new self(
			$request->getMethod(),
			$request->getUri(),
			$request->getHeaders(),
			$request->getBody(),
			$request->getProtocolVersion(),
			$request->getServerParams()
		);

		return $new->withAttributes($request->getAttributes())
			->withCookieParams($request->getCookieParams())
			->withRequestTarget($request->getRequestTarget())
			->withUploadedFiles($request->getUploadedFiles())
			->withQueryParams($request->getQueryParams());
	}

	public static function fromGlobals(): ServerRequestInterface
	{
		$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
		$headers = function_exists('getallheaders') ? getallheaders() : [];
		$uri = self::getUriFromGlobals();
		$body = new LazyOpenStream('php://input', 'r+');
		$protocol = isset($_SERVER['SERVER_PROTOCOL']) ? str_replace('HTTP/', '', $_SERVER['SERVER_PROTOCOL']) : '1.1';

		$serverRequest = new self($method, $uri, $headers, $body, $protocol, $_SERVER);

		return $serverRequest
			->withCookieParams($_COOKIE)
			->withQueryParams($_GET)
			->withParsedBody($_POST)
			->withUploadedFiles(self::normalizeFiles($_FILES));
	}

	/**
	 * @param mixed[] $attributes
	 */
	public function withAttributes(array $attributes): static
	{
		$new = $this;
		foreach ($attributes as $key => $value) {
			$new = $new->withAttribute($key, $value);
		}

		return $new;
	}

}
