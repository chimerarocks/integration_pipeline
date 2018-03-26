<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\RouteMatcher;

use Winker\IntegrationPipeline\Domain\Services\Routing\IRoute;

interface IRouteMatcherResult
{
    public function getRoute(): IRoute;

    public function getParams(): array;

    public function getParam(string $param): ?string;
}