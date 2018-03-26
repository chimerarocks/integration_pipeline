<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Services\RouteMatcher;

use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Services\RouteMatcher\IRouteMatcher;
use Winker\IntegrationPipeline\Domain\Services\RouteMatcher\IRouteMatcherResult;
use Winker\IntegrationPipeline\Domain\Services\RouteMatcher\RouterMatcherException;
use Winker\IntegrationPipeline\Domain\Services\Routing\Routes;

class RouteMatcherTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @dataProvider validRoutes
     * @param string $path
     * @param string $expectedRouteName
     * @param array $expectedParams
     */
    public function test_valid_matches(string $path, string $expectedRouteClass, array $expectedParams)
    {
        $routeMatcher = $this->container->get(IRouteMatcher::class);

        /* @var IRouteMatcherResult $routeMatcherResult */
        $routeMatcherResult = $routeMatcher->match($path);

        $this->assertInstanceOf(IRouteMatcherResult::class, $routeMatcherResult);
        $this->assertInstanceOf($expectedRouteClass, $routeMatcherResult->getRoute());
        $this->assertEquals($expectedParams, $routeMatcherResult->getParams());
    }

    public function validRoutes()
    {
        return [
            [
                '/portal',
                Routes\Portal\Collection::class,
                []
            ],
            [
                '/portal/2',
                Routes\Portal\Read::class,
                ['id' => 2]
            ],
            [
                '/unit',
                Routes\Unit\Collection::class,
                []
            ],
            [
                '/unit/2',
                Routes\Unit\Read::class,
                ['id' => 2]
            ],
            [
                '/unit/portal/2',
                Routes\Unit\ByPortal::class,
                ['id' => 2]
            ],
            [
                '/bank_account/portal/2',
                Routes\BankAccount\ByPortal::class,
                ['id' => 2]
            ]
        ];
    }

    /**
     * @dataProvider invalidRoutes
     */
    public function test_invalid_matches(string $path)
    {
        $routerMatcher = $this->container->get(IRouteMatcher::class);

        $this->expectException(RouterMatcherException::class);
        $route = $routerMatcher->match($path);
    }

    public function invalidRoutes()
    {
        return [
            [
                '/portal/'
            ],
            [
                '/portal/2/'
            ],
            [
                'unit'
            ],
            [
                '/unit/portal/2/'
            ]
        ];
    }
}