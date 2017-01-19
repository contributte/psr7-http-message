## PSR-7

`PSR-7` is HTTP message interface. It's very useful interface especially for middleware / relay pattern. Read more on official [PHP-FIG] website. 

This package is based on great [guzzle/psr7](https://github.com/guzzle/psr7) implementation. Only adds some extra features for convenient usage in [`Nette Framework`](https://github.com/nette).

## Content

- [Psr7Request - modified Guzzle PSR-7 request](#psr7request)
- [Psr7Response - modified Guzzle PSR-7 response](#psr7response)

## `Psr7Request`

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

## `Psr7Response`


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
