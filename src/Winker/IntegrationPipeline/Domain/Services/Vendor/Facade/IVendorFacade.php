<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Facade;


use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

interface IVendorFacade
{
    public function resolve(): IPropertyStrategy;

    public function transformData(array $data);
}