<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\HttpClient;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface IHttpClient
{
    public function send(ServerRequestInterface $request): ResponseInterface;
}