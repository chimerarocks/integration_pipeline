<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor;

use Psr\Http\Message\ServerRequestInterface;

abstract class Vendor implements IVendor
{
    public function headers(ServerRequestInterface $request): array
    {
        return [];
    }

    public function queryParams(ServerRequestInterface $request): array
    {
        return [];
    }

    public $baseURI = '';
}