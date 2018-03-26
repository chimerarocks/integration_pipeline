<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\RouteMatcher;

use Winker\IntegrationPipeline\Domain\Services\Routing\IRoute;

class RouterMatcherResult implements IRouteMatcherResult
{
    /**
     * @var IRoute
     */
    private $route;
    /**
     * @var array
     */
    private $params;

    public function __construct(
        IRoute $route,
        array $params
    )
    {
        $this->route = $route;
        $this->params = $params;
    }

    public function getRoute(): IRoute
    {
        return $this->route;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getParam(string $param): ?string
    {
        return $this->params[$param] ?? null;
    }
}