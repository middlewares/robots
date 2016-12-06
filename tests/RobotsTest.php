<?php

namespace Middlewares\Tests;

use Middlewares\Robots;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;

class RobotsTest extends \PHPUnit_Framework_TestCase
{
    public function testNoRobotsHeader()
    {
        $request = Factory::createServerRequest();

        $response = (new Dispatcher([
            new Robots(),
        ]))->dispatch($request);

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame('noindex, nofollow, noarchive', $response->getHeaderLine('X-Robots-Tag'));
    }

    public function testNoRobotsTxt()
    {
        $request = Factory::createServerRequest([], 'GET', '/robots.txt');

        $response = (new Dispatcher([
            new Robots(),
        ]))->dispatch($request);

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame("User-Agent: *\nDisallow: /", (string) $response->getBody());
        $this->assertSame('text/plain', $response->getHeaderLine('Content-Type'));
    }

    public function testRobotsHeader()
    {
        $request = Factory::createServerRequest();

        $response = (new Dispatcher([
            new Robots(true),
        ]))->dispatch($request);

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame('index, follow', $response->getHeaderLine('X-Robots-Tag'));
    }

    public function testRobotsTxt()
    {
        $request = Factory::createServerRequest([], 'GET', '/robots.txt');

        $response = (new Dispatcher([
            new Robots(true),
        ]))->dispatch($request);

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame("User-Agent: *\nAllow: /", (string) $response->getBody());
        $this->assertSame('text/plain', $response->getHeaderLine('Content-Type'));
    }
}
