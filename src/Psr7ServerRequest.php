<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Exception\Logical\InvalidStateException;
use Contributte\Psr7\Nette\NetteRequestTrait;
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
	 * QUERY PARAM *************************************************************
	 */

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function hasQueryParam($name)
	{
		return array_key_exists($name, $this->getQueryParams());
	}

	/**
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getQueryParam($name, $default = NULL)
	{
		if (!$this->hasQueryParam($name)) {
			if (func_num_args() < 2) {
				throw new InvalidStateException(sprintf('No query parameter "%s" found', $name));
			}

			return $default;
		}

		return $this->getQueryParams()[$name];
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

}
