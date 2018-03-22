<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies;

interface IEndpointPropertyStrategy extends IPropertyStrategy
{
    const ANNOTATION_REFERENCE = '@Endpoint';

    const DEFAULT_METHOD = 'GET';
}