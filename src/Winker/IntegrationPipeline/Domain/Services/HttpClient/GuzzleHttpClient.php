<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GuzzleHttpClient implements IHttpClient
{
    public function send(ServerRequestInterface $request): ResponseInterface
    {
        $client = new Client();
        return $client->send($request);
    }
}