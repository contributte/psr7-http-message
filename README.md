# PSR-7 - Http Message Interface

:dizzy: PSR #7 [HTTP Message Interface] to Nette Framework.

-----

[![Build Status](https://img.shields.io/travis/contributte/psr7-http-message.svg?style=flat-square)](https://travis-ci.org/contributte/psr7-http-message)
[![Code coverage](https://img.shields.io/coveralls/contributte/psr7-http-message.svg?style=flat-square)](https://coveralls.io/r/contributte/psr7-http-message)
[![HHVM Status](https://img.shields.io/hhvm/contributte/psr-7.svg?style=flat-square)](http://hhvm.h4cc.de/package/contributte/psr-7)
[![Licence](https://img.shields.io/packagist/l/contributte/psr-7.svg?style=flat-square)](https://packagist.org/packages/contributte/psr-7)

[![Downloads this Month](https://img.shields.io/packagist/dm/contributte/psr-7.svg?style=flat-square)](https://packagist.org/packages/contributte/psr-7)
[![Downloads total](https://img.shields.io/packagist/dt/contributte/psr-7.svg?style=flat-square)](https://packagist.org/packages/contributte/psr-7)
[![Latest stable](https://img.shields.io/packagist/v/contributte/psr-7.svg?style=flat-square)](https://packagist.org/packages/contributte/psr-7)
[![Latest unstable](https://img.shields.io/packagist/vpre/contributte/psr-7.svg?style=flat-square)](https://packagist.org/packages/contributte/psr-7)

## Discussion / Help

[![Join the chat](https://img.shields.io/gitter/room/contributte/contributte.svg?style=flat-square)](https://gitter.im/contributte/contributte?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## Install

```
composer require contributte/psr-7
```

## PSR-7

This package is based on great [guzzle/psr7](https://github.com/guzzle/psr7) implementation. And adds some extra features for usage in Nette Framework.

## Usage

### `Psr7Request`

The easiest way is create request over `Psr7RequestFactory`.

```php
use Contributte\Psr7\Psr7RequestFactory;

$psr7 = Psr7RequestFactory::fromGlobal();
```

```php
use Contributte\Psr7\Psr7RequestFactory;

$httpRequest = new Request();
$psr7 = Psr7RequestFactory::fromNette($httpRequest);
```

You can fill [`httpRequest`](https://api.nette.org/2.4/Nette.Http.Request.html) and [`applicationRequest`](https://api.nette.org/2.4/Nette.Application.Request.html) over methods:

```php
use Contributte\Psr7\Psr7RequestFactory;

$psr7 = Psr7RequestFactory::fromGlobal();
$psr7 = $psr7->withHttpRequest($httpRequest);
$psr7 = $psr7->withApplicationRequest($applicationRequest);
```

### `Psr7Response`


The easiest way is create request over `Psr7ResponseFactory`.

```php
use Contributte\Psr7\Psr7ResponseFactory;

$psr7 = Psr7ResponseFactory::fromGlobal();
```

```php
use Contributte\Psr7\Psr7ResponseFactory;

$httpResponse = new Response();
$psr7 = Psr7ResponseFactory::fromNette($httpResponse);
```

You can fill [`httpResponse`](https://api.nette.org/2.4/Nette.Http.Response.html) and [`applicationResponse`](https://api.nette.org/2.4/Nette.Application.IResponse.html) over methods:

```php
use Contributte\Psr7\Psr7ResponseFactory;

$psr7 = Psr7RequestFactory::fromGlobal();
$psr7 = $psr7->withHttpResponse($httpResponse);
$psr7 = $psr7->withApplicationResponse($applicationResponse);
```

-----

Thank you for testing, reporting and contributing.
