<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor;

use Psr\Http\Message\ServerRequestInterface;

interface IVendor
{
    public function headers(ServerRequestInterface $request): array;

    public function queryParams(ServerRequestInterface $request): array;
}