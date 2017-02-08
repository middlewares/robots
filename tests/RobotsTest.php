<?php

namespace Middlewares\Tests;

use Middlewares\Robots;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;
use Psr\Http\Message\ResponseInterface;

class RobotsTest extends \PHPUnit_Framework_TestCase
{
    public function testNoRobotsHeader()
    {
        $response = Dispatcher::run([
            new Robots(),
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame('noindex, nofollow, noarchive', $response->getHeaderLine('X-Robots-Tag'));
    }

    public function testNoRobotsTxt()
    {
        $request = Factory::createServerRequest([], 'GET', '/robots.txt');

        $response = Dispatcher::run([
            new Robots(),
        ], $request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame("User-Agent: *\nDisallow: /", (string) $response->getBody());
        $this->assertSame('text/plain', $response->getHeaderLine('Content-Type'));
    }

    public function testRobotsHeader()
    {
        $response = Dispatcher::run([
            new Robots(true),
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame('index, follow', $response->getHeaderLine('X-Robots-Tag'));
    }

    public function testRobotsTxt()
    {
        $request = Factory::createServerRequest([], 'GET', '/robots.txt');

        $response = Dispatcher::run([
            new Robots(true),
        ], $request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame("User-Agent: *\nAllow: /", (string) $response->getBody());
        $this->assertSame('text/plain', $response->getHeaderLine('Content-Type'));
    }

    public function testSitemap()
    {
        $request = Factory::createServerRequest([], 'GET', '/robots.txt');

        $response = Dispatcher::run([
            (new Robots(true))->sitemap('http://localhost.com/sitemap.xml'),
        ], $request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame("User-Agent: *\nAllow: /\nSitemap: http://localhost.com/sitemap.xml", (string) $response->getBody());
        $this->assertSame('text/plain', $response->getHeaderLine('Content-Type'));
    }
}
