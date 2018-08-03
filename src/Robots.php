<?php
declare(strict_types = 1);

namespace Middlewares;

use Middlewares\Utils\Traits\HasResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Robots implements MiddlewareInterface
{
    use HasResponseFactory;

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
     */
    public function sitemap(string $sitemap): self
    {
        $this->sitemap = $sitemap;

        return $this;
    }

    /**
     * Process a request and return a response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getUri()->getPath() === '/robots.txt') {
            $response = $this->createResponse();

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

        $response = $handler->handle($request);

        if ($this->allow) {
            return $response->withHeader(self::HEADER, 'index, follow');
        }

        return $response->withHeader(self::HEADER, 'noindex, nofollow, noarchive');
    }
}
