<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies;

interface IServicePropertyStrategy extends IPropertyStrategy
{
    const ANNOTATION_REFERENCE = '@Service';
}