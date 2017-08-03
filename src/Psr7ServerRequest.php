<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Nette\NetteRequestTrait;
use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\ServerRequest;
use InvalidArgumentException;
use Nette\Http\FileUpload;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 *
 * @method Psr7UploadedFile[] getUploadedFiles()
 * @method self withAttribute($name, $value)
 */
class Psr7ServerRequest extends ServerRequest
{

	use NetteRequestTrait;
	use ExtraRequestTrait;

	/**
	 * @param array $files
	 * @return Psr7UploadedFile[]
	 */
	public static function normalizeNetteFiles(array $files)
	{
		$normalized = [];

		foreach ($files as $file) {
			if (!($file instanceof FileUpload)) {
				throw new InvalidArgumentException('Invalid value in files specification');
			}

			$normalized[] = new Psr7UploadedFile(
				$file->getTemporaryFile(),
				intval($file->getSize()),
				$file->getError(),
				$file->getName(),
				$file->getContentType()
			);
		}

		return $normalized;
	}

	/**
	 * ATTRIBUTES **************************************************************
	 */

	/**
	 * @param array $attributes
	 * @return static
	 */
	public function withAttributes(array $attributes)
	{
		$new = $this;
		foreach ($attributes as $key => $value) {
			$new = $new->withAttribute($key, $value);
		}

		return $new;
	}

	/**
	 * FACTORY *****************************************************************
	 */

	/**
	 * @param ServerRequestInterface $request
	 * @return static
	 */
	public static function of(ServerRequestInterface $request)
	{
		$new = new static(
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

	/**
	 * @return Psr7ServerRequest
	 */
	public static function fromGlobals()
	{
		$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
		$headers = function_exists('getallheaders') ? getallheaders() : [];
		$uri = self::getUriFromGlobals();
		$body = new LazyOpenStream('php://input', 'r+');
		$protocol = isset($_SERVER['SERVER_PROTOCOL']) ? str_replace('HTTP/', '', $_SERVER['SERVER_PROTOCOL']) : '1.1';

		$serverRequest = new static($method, $uri, $headers, $body, $protocol, $_SERVER);

		return $serverRequest
			->withCookieParams($_COOKIE)
			->withQueryParams($_GET)
			->withParsedBody($_POST)
			->withUploadedFiles(self::normalizeFiles($_FILES));
	}

}
