<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Consumer\EndpointConsumerStrategy;

use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Services\HttpClient\IHttpClient;

class PsrClientConsumer implements EndpointConsumerStrategy
{
    /**
     * @var IHttpClient
     */
    private $httpClient;

    public function __construct(IHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function consume(ServerRequestInterface $request): array
    {
        $response = $this->httpClient->send($request);
        $jsonDecoded = json_decode((string) $response->getBody(), true);
        if ($jsonDecoded) {
            return $jsonDecoded;
        }
        return [$response];
    }
}