<?php

namespace Middlewares\Tests;

use Middlewares\Robots;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use mindplay\middleman\Dispatcher;

class RobotsTest extends \PHPUnit_Framework_TestCase
{
    public function testNoRobotsHeader()
    {
        $response = (new Dispatcher([
            new Robots(),
            function () {
                return new Response();
            },
        ]))->dispatch(new Request());

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame('noindex, nofollow, noarchive', $response->getHeaderLine('X-Robots-Tag'));
    }

    public function testNoRobotsTxt()
    {
        $response = (new Dispatcher([
            new Robots(),
            function () {
                return new Response();
            },
        ]))->dispatch(new Request('/robots.txt'));

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame("User-Agent: *\nDisallow: /", (string) $response->getBody());
    }

    public function testRobotsHeader()
    {
        $response = (new Dispatcher([
            new Robots(true),
            function () {
                return new Response();
            },
        ]))->dispatch(new Request());

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame('index, follow', $response->getHeaderLine('X-Robots-Tag'));
    }

    public function testRobotsTxt()
    {
        $response = (new Dispatcher([
            new Robots(true),
            function () {
                return new Response();
            },
        ]))->dispatch(new Request('/robots.txt'));

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertSame("User-Agent: *\nAllow: /", (string) $response->getBody());
    }
}
