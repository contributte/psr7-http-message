<?php declare(strict_types = 1);

/**
 * Test: Psr7Message
 */

use Contributte\Psr7\Psr7Message;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

test(function (): void {
	$message = new Psr7Message();
	Assert::equal('', $message->getHeaderLine('foo'));

	$message = $message->withAddedHeader('foo', 'bar');
	Assert::equal('bar', $message->getHeaderLine('foo'));
});
