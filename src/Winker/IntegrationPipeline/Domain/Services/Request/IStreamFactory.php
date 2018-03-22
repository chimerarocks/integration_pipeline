<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Request;

use Psr\Http\Message\StreamInterface;

interface IStreamFactory
{
    public function make(?string $body = ''): StreamInterface;
}