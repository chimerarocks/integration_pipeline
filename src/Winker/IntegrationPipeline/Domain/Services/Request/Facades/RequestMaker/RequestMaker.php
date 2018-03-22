<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Request\Facades\RequestMaker;

use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Services\Request\IStreamFactory;
use Winker\IntegrationPipeline\Domain\Services\Request\IUriFactory;
use Winker\IntegrationPipeline\Domain\Services\Request\RequestFactory;

class RequestMaker implements IRequestMaker
{
    /**
     * @var RequestFactory
     */
    private $requestFactory;
    /**
     * @var IUriFactory
     */
    private $uriFactory;
    /**
     * @var IStreamFactory
     */
    private $streamFactory;

    private $uri;

    private $stream;

    private $headers;

    private $method;
    /**
     * @var ServerRequestInterface $request
     */
    private $request;

    public function __construct(
        RequestFactory $requestFactory,
        IUriFactory $uriFactory,
        IStreamFactory $streamFactory
    )
    {
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
        $this->streamFactory = $streamFactory;
    }


    /**
     * @param string $fullUri
     * @param string $method
     * @param array $headers
     * @param string $stream
     * @param array $queryParams
     * @return ServerRequestInterface
     * @throws \Winker\IntegrationPipeline\Domain\Services\Request\Exceptions\InvalidUriFormatException
     */
    public function make(string $fullUri, string $method, array $headers, ?string $stream = '', array $queryParams = []): ServerRequestInterface
    {
        $this->createUri($fullUri);
        $this->createStream($stream);
        $this->handleHeaders($headers);
        $this->createRequest($method);
        $this->handleQueryParams($queryParams);

        return $this->request;
    }


    /**
     * @param string $fullUri
     * @throws \Winker\IntegrationPipeline\Domain\Services\Request\Exceptions\InvalidUriFormatException
     */
    private function createUri(string $fullUri): void
    {
        $this->uri = $this->uriFactory->make($fullUri);
    }

    /**
     * @param string $stream
     */
    private function createStream(?string $stream): void
    {
        $this->stream = $this->streamFactory->make($stream);
    }

    /**
     * @param array $headers
     */
    private function handleHeaders(array $headers): void
    {
        $this->headers = $headers;
        if ($this->itNeedsSetJsonContentType()) {
            $headers['Content-type'] = 'application/json';
        }
    }


    private function itNeedsSetJsonContentType(): bool
    {
        $lowercaseHeaders = array_change_key_case($this->headers, CASE_LOWER);
        return $this->stream &&
            json_decode((string) $this->stream) &&
            array_key_exists('content-type', $lowercaseHeaders);
    }

    /**
     * @param string $method
     */
    private function createRequest(string $method): void
    {
        $this->method = $method;
        $this->request = $this->requestFactory->make(
            $this->uri,
            $this->method,
            $this->headers,
            $this->stream
        );
    }

    private function handleQueryParams(array $queryParams)
    {
        $this->request = $this->request->withQueryParams($queryParams);
    }
}