<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Routing\Routes\UserUnit;

use Winker\IntegrationPipeline\Domain\Services\Routing\IRoute;
use Winker\IntegrationPipeline\Domain\Services\Routing\RouteAccess;
use Winker\IntegrationPipeline\Domain\Services\Routing\Routes\UserUnit\RouteName;
use Winker\IntegrationPipeline\Domain\Services\Routing\Type\CollectionRouteType;

class Collection implements IRoute
{
    use RouteAccess, RouteName, CollectionRouteType;
}