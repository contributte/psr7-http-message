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

[![Join the chat](https://img.shields.io/gitter/room/contributte/contributte.svg?style=flat-square)](http://bit.ly/ctteg)

## Install

```
composer require contributte/psr-7
```

## Versions

| State       | Version | Branch   | PHP      |
|-------------|---------|----------|----------|
| development | `^0.1`  | `master` | `>= 5.6` |

## Prolog

Middleware / Relay pattern is widely used for handling any HTTP requests, such as API request, streams, dynamic websites 
or just any suitable requests.

We have a many solutions and prepared libraries in PHP world. 

This packages is based on great a probably best known library for PSR-7, it's called [guzzle/psr-7](https://github.com/guzzle/psr7).

Other libraries:

- [oscarotero/psr7-middlewares](https://github.com/oscarotero/psr7-middlewares) - biggest collection of PHP middlewares
- [stackphp](https://github.com/stackphp) - connect middleware pattern and symfony HttpKernel
- [zendframework/zend-diactoros](https://github.com/zendframework/zend-diactoros/) - Zend PSR-7 middleware

## Overview

- [Psr7Request](https://github.com/contributte/psr7-http-message/tree/master/.docs#psr7request)
- [Psr7Response](https://github.com/contributte/psr7-http-message/tree/master/.docs#psr7response)

-----

The development is sponsored by [Tlapnet](http://www.tlapnet.cz). Thank you guys! :+1:

-----

Thank you for testing, reporting and contributing.
