# middlewares/robots

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]
[![SensioLabs Insight][ico-sensiolabs]][link-sensiolabs]

Middleware to enable/disable the robots of the search engines for non-production environment. Adds automatically the header `X-Robots-Tag` in all responses and returns a default body for `/robots.txt` request.

## Requirements

* PHP >= 7.0
* A [PSR-7](https://packagist.org/providers/psr/http-message-implementation) http mesage implementation ([Diactoros](https://github.com/zendframework/zend-diactoros), [Guzzle](https://github.com/guzzle/psr7), [Slim](https://github.com/slimphp/Slim), etc...)
* A [PSR-15 middleware dispatcher](https://github.com/middlewares/awesome-psr15-middlewares#dispatcher)

## Installation

This package is installable and autoloadable via Composer as [middlewares/robots](https://packagist.org/packages/middlewares/robots).

```sh
composer require middlewares/robots
```

## Example

```php
$dispatcher = new Dispatcher([
	new Middlewares\Robots(false)
]);

$response = $dispatcher->dispatch(new ServerRequest());

echo $response->getHeaderLine('X-Robots-Tag'); //noindex, nofollow, noarchive
```

## Options

#### `__construct(bool $allow)`

Set `true` to allow search engines and `false` to disallow.

#### `sitemap(string $sitemap)`

Optional url of a sitemap file.

---

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes and [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/middlewares/robots.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/middlewares/robots/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/g/middlewares/robots.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/middlewares/robots.svg?style=flat-square
[ico-sensiolabs]: https://img.shields.io/sensiolabs/i/3dee251b-f66d-4082-8193-9611300bd068.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/middlewares/robots
[link-travis]: https://travis-ci.org/middlewares/robots
[link-scrutinizer]: https://scrutinizer-ci.com/g/middlewares/robots
[link-downloads]: https://packagist.org/packages/middlewares/robots
[link-sensiolabs]: https://insight.sensiolabs.com/projects/3dee251b-f66d-4082-8193-9611300bd068
