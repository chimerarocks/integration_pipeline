<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Request\Facades\RequestMaker;


use Psr\Http\Message\ServerRequestInterface;

interface IRequestMaker
{
    public function make(string $uri, string $method, array $headers, ?string $stream = '', array $queryParams = []): ServerRequestInterface;
}