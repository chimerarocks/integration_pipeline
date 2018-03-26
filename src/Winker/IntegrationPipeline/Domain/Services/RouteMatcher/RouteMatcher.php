<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\RouteMatcher;

use Winker\IntegrationPipeline\Domain\Services\Routing\IRoute;
use Winker\IntegrationPipeline\Domain\Services\Routing\Routes;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\IConsumePropertiesMapper;

class RouteMatcher implements IRouteMatcher
{
    private $routes;

    public function __construct()
    {
        $this->getRouting();
    }

    /**
     * @param string $path
     * @return RouterMatcherResult
     * @throws RouterMatcherException
     */
    public function match(string $path): RouterMatcherResult
    {
        /* @var $route IRoute */
        foreach ($this->routes as $route) {
            $regex = '/^'. preg_quote($route->getRule(), '/') . '$/';
            preg_match('/\\\{(.*?)\\\}/', $regex, $paramsMatches);
            $regex = preg_replace('/\\\{.*?\\\}/', '([^\/]+)', $regex);
            if (preg_match($regex, $path, $match)) {
                $params = [];
                for ($i=1; $i < count($paramsMatches); $i++) {
                    $params[$paramsMatches[$i]] = $match[$i];
                }
                return new RouterMatcherResult($route, $params);
            }
        }
        throw new RouterMatcherException($path);
    }

    private function getRouting()
    {
        $this->routes = [
            new Routes\Portal\Read(),
            new Routes\Portal\Collection(),
            new Routes\BankAccount\Collection(),
            new Routes\BankAccount\Read(),
            new Routes\BankAccount\ByPortal(),
            new Routes\Unit\Collection(),
            new Routes\Unit\Read(),
            new Routes\Unit\ByPortal(),
            new Routes\UserUnit\Collection(),
            new Routes\UserUnit\Read(),
            new Routes\UserUnit\ByPortal(),
            new Routes\BillingUnit\Collection(),
            new Routes\BillingUnit\Read(),
            new Routes\BillingUnit\ByPortal(),
            new Routes\ManagerMandate\Collection(),
            new Routes\ManagerMandate\Read(),
            new Routes\ManagerMandate\ByPortal()
        ];
    }
}