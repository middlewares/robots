# middlewares/robots

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]

Middleware to enable/disable the robots of the search engines for non-production environment. Adds automatically the header `X-Robots-Tag` in all responses and returns a default body for `/robots.txt` request.

## Requirements

* PHP >= 7.2
* A [PSR-7 http library](https://github.com/middlewares/awesome-psr15-middlewares#psr-7-implementations)
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

## Usage

The constructor's first argument configure whether block or not search engines.

```php
//Disallow search engine robots
$robots = new Middlewares\Robots(false);

//Allow search engine robots
$robots = new Middlewares\Robots(true);
```

Optionally, you can provide a `Psr\Http\Message\ResponseFactoryInterface` as the second argument to create the response of the requests to `/robots.txt`. If it's not defined, [Middleware\Utils\Factory](https://github.com/middlewares/utils#factory) will be used to detect it automatically.

```php
$responseFactory = new MyOwnResponseFactory();

$robots = new Middlewares\Robots(false, $responseFactory);
```

### sitemap

If your site has a sitemap, use this option to add the url to `robots.txt` responses.

```php
$robots = (new Middlewares\Robots(true))->sitemap('/sitemap.xml');
```
---

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes and [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/middlewares/robots.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/middlewares/robots/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/g/middlewares/robots.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/middlewares/robots.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/middlewares/robots
[link-travis]: https://travis-ci.org/middlewares/robots
[link-scrutinizer]: https://scrutinizer-ci.com/g/middlewares/robots
[link-downloads]: https://packagist.org/packages/middlewares/robots
