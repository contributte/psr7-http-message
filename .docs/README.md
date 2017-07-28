## PSR-7

`PSR-7` is HTTP message interface. It's very useful interface especially for middleware / relay pattern. Read more on official [PHP-FIG](http://www.php-fig.org/psr/psr-7/) website. 

This package is based on great [guzzle/psr7](https://github.com/guzzle/psr7) implementation. Only adds some extra features for convenient usage in [`Nette Framework`](https://github.com/nette).


## Content

- [Psr7Request - modified Guzzle PSR-7 request](#psr7request)
- [Psr7Response - modified Guzzle PSR-7 response](#psr7response)


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

You can fill [`httpRequest`](https://api.nette.org/2.4/Nette.Http.Request.html) and [`applicationRequest`](https://api.nette.org/2.4/Nette.Application.Request.html) over methods:

```php
use Contributte\Psr7\Psr7RequestFactory;

$psr7 = Psr7RequestFactory::fromGlobal();
$psr7 = $psr7->withHttpRequest($httpRequest);
$psr7 = $psr7->withApplicationRequest($applicationRequest);
```


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

You can fill [`httpResponse`](https://api.nette.org/2.4/Nette.Http.Response.html) and [`applicationResponse`](https://api.nette.org/2.4/Nette.Application.IResponse.html) over methods:

```php
use Contributte\Psr7\Psr7ResponseFactory;

$psr7 = Psr7RequestFactory::fromGlobal();
$psr7 = $psr7->withHttpResponse($httpResponse);
$psr7 = $psr7->withApplicationResponse($applicationResponse);
```


## API

**MessageInterface**

- `getProtocolVersion: string`
- `withProtocolVersion($version): static`
- `getHeaders(): array`
- `hasHeader($name): bool`
- `getHeader($name): string[]`
- `getHeaderLine($name): string`
- `withHeader($name, $value): static`
- `withAddedHeader($name, $value): static`
- `withoutHeader($name): static`
- `getBody(): StreamInterface`
- `withBody(StreamInterface $body): static`

**RequestInterface** << **MessageInterface**

- `getRequestTarget(): string`
- `withRequestTarget($requestTarget): static`
- `getMethod(): string`
- `withMethod($method): static`
- `getUri(): UriInterface`
- `withUri(UriInterface $uri, $preserveHost = false): static`

**ServerRequestInterface** << **RequestInterface**

- `getServerParams(): array`
- `getCookieParams(): array`
- `withCookieParams(array $cookies): static`
- `getQueryParams(): array`
- `withQueryParams(array $query): static`
- `getUploadedFiles(): UploadedFileInterface[]`
- `withUploadedFiles(array $uploadedFiles): static`
- `getParsedBody(): mixed`
- `withParsedBody($data): static`
- `getAttributes(): mixed[]`
- `getAttribute($name, $default = null): mixed`
- `withAttribute($name, $value): static`
- `withoutAttribute($name): static`

**ResponseInterface** << **MessageInterface**

- `getStatusCode(): int`
- `withStatus($code, $reasonPhrase = ''): static`
- `getReasonPhrase(): string`

**StreamInterface**

- `__toString(): string`
- `close(): void`
- `detach(): ?resource`
- `getSize(): ?int`
- `tell(): int`
- `eof(): bool`
- `isSeekable(): bool`
- `seek($offset, $whence = SEEK_SET): void`
- `rewind(): void`
- `isWritable(): bool`
- `write($string): void`
- `isReadable(): bool`
- `read($length): string`
- `getContents(): string`
- `getMetadata($key = null): mixed`

**UriInterface**

- `getScheme(): string`
- `withScheme($scheme): static`
- `getAuthority(): string`
- `getUserInfo(): string`
- `withUserInfo($user, $password = null): static`
- `getHost(): string`
- `withHost($host): static`
- `getPort(): ?int`
- `withPort($port): static`
- `getPath(): string`
- `withPath($path): static`
- `getQuery(): string`
- `withQuery($query): static`
- `getFragment(): string`
- `withFragment($fragment): static`
- `__toString(): string`

**UploadedFileInterface**

- `getStream(): StreamInterface`
- `moveTo($targetPath): void`
- `getSize(): ?int`
- `getError(): int`
- `getClientFilename(): ?string`
- `getClientMediaType(): ?string`
