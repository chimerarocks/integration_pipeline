<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Routing\Routes\BankAccount;

use Winker\IntegrationPipeline\Domain\Services\Routing\IRoute;
use Winker\IntegrationPipeline\Domain\Services\Routing\RouteAccess;
use Winker\IntegrationPipeline\Domain\Services\Routing\Routes\BankAccount\RouteName;
use Winker\IntegrationPipeline\Domain\Services\Routing\Type\ReadRouteType;

class Read implements IRoute
{
    use RouteAccess, RouteName, ReadRouteType;
}