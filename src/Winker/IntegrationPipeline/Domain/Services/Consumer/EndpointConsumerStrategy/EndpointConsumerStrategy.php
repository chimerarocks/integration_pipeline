<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Consumer\EndpointConsumerStrategy;

use Psr\Http\Message\ServerRequestInterface;

interface EndpointConsumerStrategy
{
    public function consume(ServerRequestInterface $request): array;
}