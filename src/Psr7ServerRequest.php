<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Nette\NetteRequestTrait;
use GuzzleHttp\Psr7\ServerRequest;
use InvalidArgumentException;
use Nette\Http\FileUpload;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 *
 * @method Psr7UploadedFile[] getUploadedFiles()
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

}
