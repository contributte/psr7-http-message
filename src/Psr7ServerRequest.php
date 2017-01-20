<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Nette\NetteRequestTrait;
use GuzzleHttp\Psr7\ServerRequest;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Psr7ServerRequest extends ServerRequest
{

	use NetteRequestTrait;

}
