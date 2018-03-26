<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Consumer;

use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Contracts\ServiceContract;
use Winker\IntegrationPipeline\Domain\Services\RouteMatcher\RouteMatcher;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IServicePropertyStrategy;

class ServiceConsumer extends Consumer
{
    /**
     * @var RouteMatcher
     */
    private $routeMatcher;
    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(RouteMatcher $routeMatcher, ServerRequestInterface $request)
    {
        $this->routeMatcher = $routeMatcher;
        $this->request = $request;
    }

    protected function canConsume(IPropertyStrategy $propertyStrategy)
    {
        return $propertyStrategy instanceof IServicePropertyStrategy &&
            $propertyStrategy->resolve() instanceof ServiceContract;
    }

    /**
     * @param IPropertyStrategy $propertyStrategy
     * @return array
     * @throws \Winker\IntegrationPipeline\Domain\Services\RouteMatcher\RouterMatcherException
     */
    protected function resolve(IPropertyStrategy $propertyStrategy): array
    {
        /* @var ServiceContract $service */
        $service = $propertyStrategy->resolve();
        $path = $this->request->getUri()->getPath();
        $route = $this->routeMatcher->match($path)->getRoute();

        if ($route->isReadRoute()) {
            return $service->read($this->request);
        }
        if ($route->isCollectionRoute()) {
            return $service->collection($this->request);
        }
        if ($route->isByPortalRoute()) {
            return $service->byPortal($this->request);
        }
    }
}