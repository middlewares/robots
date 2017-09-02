<?php

namespace Middlewares;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Robots implements MiddlewareInterface
{
    const HEADER = 'X-Robots-Tag';

    /**
     * @var bool
     */
    private $allow;

    /**
     * @var string|null
     */
    private $sitemap;

    /**
     * Set whether search engines robots are allowed or not.
     *
     * @param bool $allow
     */
    public function __construct($allow)
    {
        $this->allow = (bool) $allow;
    }

    /**
     * Set the path to the sitemap file.
     *
     * @param string $sitemap
     *
     * @return self
     */
    public function sitemap($sitemap)
    {
        $this->sitemap = $sitemap;

        return $this;
    }

    /**
     * Process a request and return a response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if ($request->getUri()->getPath() === '/robots.txt') {
            $response = Utils\Factory::createResponse();

            $body = ['User-Agent: *'];

            if ($this->allow) {
                $body[] = 'Allow: /';
            } else {
                $body[] = 'Disallow: /';
            }

            if (!empty($this->sitemap)) {
                $body[] = "Sitemap: {$this->sitemap}";
            }

            $response->getBody()->write(implode("\n", $body));

            return $response->withHeader('Content-Type', 'text/plain');
        }

        $response = $delegate->process($request);

        if ($this->allow) {
            return $response->withHeader(self::HEADER, 'index, follow');
        }

        return $response->withHeader(self::HEADER, 'noindex, nofollow, noarchive');
    }
}
