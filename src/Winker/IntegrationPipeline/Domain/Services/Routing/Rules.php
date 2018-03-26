<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Routing;

interface Rules
{
    const COLLECTION_RULE = '/%name%';
    const READ_RULE = '/%name%/{id}';
    const BY_PORTAL_RULE = '/%name%/portal/{id}';
}