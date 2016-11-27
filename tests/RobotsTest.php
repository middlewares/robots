<?php

namespace Middlewares\Tests;

use Middlewares\Robots;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\CallableMiddleware;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;

class RobotsTest extends \PHPUnit_Framework_TestCase
{
    public function testNoRobotsHeader()
    {
        $response = (new Dispatcher([
            new Robots(),
            new CallableMiddleware(function () {
                return new Response();
            }),
        ]))->dispatch(new ServerRequest());

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame('noindex, nofollow, noarchive', $response->getHeaderLine('X-Robots-Tag'));
    }

    public function testNoRobotsTxt()
    {
        $response = (new Dispatcher([
            new Robots(),
            new CallableMiddleware(function () {
                return new Response();
            }),
        ]))->dispatch(new ServerRequest([], [], '/robots.txt'));

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame("User-Agent: *\nDisallow: /", (string) $response->getBody());
    }

    public function testRobotsHeader()
    {
        $response = (new Dispatcher([
            new Robots(true),
            new CallableMiddleware(function () {
                return new Response();
            }),
        ]))->dispatch(new ServerRequest());

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame('index, follow', $response->getHeaderLine('X-Robots-Tag'));
    }

    public function testRobotsTxt()
    {
        $response = (new Dispatcher([
            new Robots(true),
            new CallableMiddleware(function () {
                return new Response();
            }),
        ]))->dispatch(new ServerRequest([], [], '/robots.txt'));

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame("User-Agent: *\nAllow: /", (string) $response->getBody());
    }
}
