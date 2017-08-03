<?php

/**
 * Test: Psr7Uri
 */

use Contributte\Psr7\Psr7Uri;
use Nette\Http\UrlScript;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// Nette - UrlScript
test(function () {
	$uri = new Psr7Uri();
	$uri = $uri->withUrlScript(new UrlScript('contributte.org'));

	Assert::equal('contributte.org', $uri->getUrlScript()->__toString());
});
