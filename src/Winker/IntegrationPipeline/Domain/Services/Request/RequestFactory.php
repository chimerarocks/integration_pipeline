<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Request;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class RequestFactory implements IRequestFactory
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function make(UriInterface $uri, string $method, ?array $headers = [], ?StreamInterface $stream = null, array $queryParams = []): ServerRequestInterface
    {
        $this->handleUri($uri, $queryParams);
        $this->handleMethod($method);
        $this->handleHeaders($headers);
        $this->handleBody($stream);

        return $this->request;
    }

    private function handleUri(UriInterface $uri, array $queryParams): void
    {
        $this->request = $this->request->withUri($uri);
        $this->request = $this->request->withQueryParams($queryParams);
    }

    private function handleMethod(string $method): void
    {
        $this->request = $this->request->withMethod($method);
    }

    private function handleHeaders(?array $headers = []): void
    {
        foreach (IRequestFactory::DEFAULT_HEADERS as $header => $value) {
            $this->request = $this->request->withHeader($header, $value);
        }
        foreach ($headers as $header => $value) {
            $this->request = $this->request->withHeader($header, $value);
        }
    }

    private function handleBody(?StreamInterface $stream = null)
    {
        if ($stream !== null) {
            $this->request = $this->request->withBody($stream);
        }
    }
}