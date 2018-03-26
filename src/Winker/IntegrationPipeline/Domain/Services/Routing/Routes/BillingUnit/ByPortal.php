<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Routing\Routes\BillingUnit;

use Winker\IntegrationPipeline\Domain\Services\Routing\IRoute;
use Winker\IntegrationPipeline\Domain\Services\Routing\RouteAccess;
use Winker\IntegrationPipeline\Domain\Services\Routing\Routes\BillingUnit\RouteName;
use Winker\IntegrationPipeline\Domain\Services\Routing\Type\ByPortalRouteType;

class ByPortal implements IRoute
{
    use RouteAccess, RouteName, ByPortalRouteType;
}