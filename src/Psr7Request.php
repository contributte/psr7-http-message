<?php

namespace Contributte\Psr7;

use Contributte\Psr7\Nette\NetteRequestTrait;
use GuzzleHttp\Psr7\Request;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Psr7Request extends Request
{

	use NetteRequestTrait;

}
