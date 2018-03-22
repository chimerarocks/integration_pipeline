<?php
declare(strict_types=1);

namespace Test\Stubs\Services;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Services\HttpClient\IHttpClient;

class HttpClient implements IHttpClient
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = json_encode($data);
    }

    public function send(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(200, [], $this->data);
    }
}