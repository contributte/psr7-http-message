![](https://heatbadger.now.sh/github/readme/contributte/psr7-http-message/)

<p align=center>
    <a href="https://github.com/contributte/psr7-http-message/actions"><img src="https://badgen.net/github/checks/contributte/psr7-http-message"></a>
    <a href="https://codecov.io/gh/contributte/psr7-http-message"><img src="https://badgen.net/codecov/c/github/contributte/psr7-http-message"></a>
    <a href="https://packagist.org/packages/contributte/psr7-http-message"><img src="https://badgen.net/packagist/dm/contributte/psr7-http-message"></a>
    <a href="https://packagist.org/packages/contributte/psr7-http-message"><img src="https://badgen.net/packagist/v/contributte/psr7-http-message"></a>
</p>
<p align=center>
    <a href="https://packagist.org/packages/contributte/psr7-http-message"><img src="https://badgen.net/packagist/php/contributte/psr7-http-message"></a>
    <a href="https://github.com/contributte/psr7-http-message"><img src="https://badgen.net/github/license/contributte/psr7-http-message"></a>
    <a href="https://bit.ly/ctteg"><img src="https://badgen.net/badge/support/gitter/cyan"></a>
    <a href="https://bit.ly/cttfo"><img src="https://badgen.net/badge/support/forum/yellow"></a>
    <a href="https://contributte.org/partners.html"><img src="https://badgen.net/badge/sponsor/donations/F96854"></a>
</p>

<p align=center>
    Website 🚀 <a href="https://contributte.org">contributte.org</a> | Contact 👨🏻‍💻 <a href="https://f3l1x.io">f3l1x.io</a> | Twitter 🐦 <a href="https://twitter.com/contributte">@contributte</a>
</p>

PSR-7 (HTTP Message Interface) to Nette Framework.

## Versions

| State       | Version | Branch   | Nette | PHP     |
|-------------|---------|----------|-------|---------|
| dev         | `^0.10` | `master` | 3.2+  | `>=8.2` |
| stable      | `^0.9`  | `master` | 3.2+  | `>=8.2` |

`PSR-7` is HTTP message interface. It's very useful interface especially for middleware / relay pattern. Read more on official [PHP-FIG](http://www.php-fig.org/psr/psr-7/) website.

This package is based on great [guzzle/psr7](https://github.com/guzzle/psr7) implementation. Only adds some extra features for convenient usage in [`Nette Framework`](https://github.com/nette).

## Contents

- [Installation](#installation)
- [Psr7Request](#psr7request)
- [Psr7ServerRequest](#psr7serverrequest)
- [Psr7Response](#psr7response)
- [Bridge](#bridge)
- [API](#api)

## Installation

```bash
composer require contributte/psr7-http-message
```

## `Psr7Request`

The easiest way is to create request using `Psr7RequestFactory`.

```php
use Contributte\Psr7\Psr7RequestFactory;

$psr7 = Psr7RequestFactory::fromGlobal();
```

In Nette application we can use existing `Nette\Http\Request`.

```php
use Contributte\Psr7\Psr7RequestFactory;

$httpRequest = new Request();
$psr7 = Psr7RequestFactory::fromNette($httpRequest);
```

You can fill `Nette\Http\Request` and `Nette\Application\Request` over methods:

```php
use Contributte\Psr7\Psr7RequestFactory;

$psr7 = Psr7RequestFactory::fromGlobal();
$psr7 = $psr7->withHttpRequest($httpRequest);
$psr7 = $psr7->withApplicationRequest($applicationRequest);
```

Additional methods (against PSR7 interface):
- of(RequestInterface $request): self
- getContents(): mixed
- getContentsCopy(): mixed
- getJsonBody(bool $associative = true): mixed
- getJsonBodyCopy(bool $associative = true): mixed
- withNewUri(string $uri): self - returns clone with given url

## `Psr7ServerRequest`

Additional methods (against PSR7 interface):
- normalizeNetteFiles(Nette\Http\FileUpload[] $files): Psr7UploadedFile[]
- of(ServerRequestInterface $request): self
- fromGlobals(): self
- withAttributes(array $attributes): self
- hasQueryParam(string $name): bool
- getQueryParam(string $name, mixed $default = null): mixed

## `Psr7Response`

The easiest way is to create request using `Psr7ResponseFactory`.

```php
use Contributte\Psr7\Psr7ResponseFactory;

$psr7 = Psr7ResponseFactory::fromGlobal();
```

In Nette application we can use existing `Nette\Http\Response`.

```php
use Contributte\Psr7\Psr7ResponseFactory;

$httpResponse = new Response();
$psr7 = Psr7ResponseFactory::fromNette($httpResponse);
```

You can fill `Nette\Http\Response` and `Nette\Application\IResponse` over methods:

```php
use Contributte\Psr7\Psr7ResponseFactory;

$psr7 = Psr7ResponseFactory::fromGlobal();
$psr7 = $psr7->withHttpResponse($httpResponse);
$psr7 = $psr7->withApplicationResponse($applicationResponse);
```

Additional methods (against PSR7 interface):
- of(ResponseInterface $response): self
- fromGlobals(): self
- appendBody(mixed $body): self
- rewindBody(): self
- writeBody(mixed $body): self
- writeJsonBody(array $data): self
- writeJsonObject(JsonSerializable $object): self
- getJsonBody(bool $associative = true): mixed
- getContents(bool $rewind = true): mixed
- withHeaders(array $headers): self
- getHttpResponse(): ?Nette\Http\IResponse
- withHttpResponse(Nette\Http\IResponse $response)
- hasHttpResponse(): bool
- getApplicationResponse(): ?Nette\Application\IResponse
- withApplicationResponse(Nette\Application\IResponse $response)
- hasApplicationResponse(): bool
- send(): void
- sendHeaders(): void
- sendBody(): void

## Bridge

### `Psr7Response`

Nette Application response that wraps a PSR-7 `ResponseInterface`. Allows sending PSR-7 responses directly from Nette presenters.

```php
use Contributte\Psr7\Bridge\Psr7Response;

$this->sendResponse(new Psr7Response($psr7));
```

## API

This package wraps [guzzle/psr7](https://github.com/guzzle/psr7) and implements standard PSR-7 interfaces:

- `Psr\Http\Message\RequestInterface`
- `Psr\Http\Message\ServerRequestInterface`
- `Psr\Http\Message\ResponseInterface`
- `Psr\Http\Message\StreamInterface`
- `Psr\Http\Message\UriInterface`
- `Psr\Http\Message\UploadedFileInterface`

See the official [PSR-7 specification](https://www.php-fig.org/psr/psr-7/) for full interface details. Package-specific helper methods are documented above.

## Development

See [how to contribute](https://contributte.org) to this package. This package is currently maintained by these authors.

<a href="https://github.com/f3l1x">
    <img width="80" height="80" src="https://avatars.githubusercontent.com/f3l1x">
</a>

-----

Consider to [support](https://contributte.org/partners) **contributte** development team.
Also thank you for using this package.
