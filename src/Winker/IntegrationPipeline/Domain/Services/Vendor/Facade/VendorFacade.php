<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Facade;

use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Services\Request\Facades\RequestMaker\IRequestMaker;
use Winker\IntegrationPipeline\Domain\Services\RouteMatcher\IRouteMatcher;
use Winker\IntegrationPipeline\Domain\Services\Vendor\IVendor;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\IConsumePropertiesMapper;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ServiceContainerContract;

class VendorFacade implements IVendorFacade
{
    private $vendor;

    private $consumePropertiesMapper;

    private $requestedRoute;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(
        ServerRequestInterface $request,
        IConsumePropertiesMapper $consumePropertiesMapper,
        IVendor $vendor,
        IRequestMaker $requestMaker,
        ServiceContainerContract $container,
        IRouteMatcher $routeMatcher
    )
    {
        $this->vendor = $vendor;
        $this->requestedRoute = $routeMatcher
                ->match($request->getUri()->getPath())
                ->getRoute()
        ;
        $this->consumePropertiesMapper = $consumePropertiesMapper;
        $this->request = $request;
    }

    public function resolve(): IPropertyStrategy
    {
        return $this->getRequestedPropertyStrategy();
    }

    public function transformData(array $data)
    {
        $translator = $this->consumePropertiesMapper
            ->getRequestedPropertyTranslator($this->requestedRoute->getName());

        if ($this->requestedRoute->isReadRoute()) {
            return $translator->toWinker($data);
        }

        return $translator->toWinkerList($data);
    }

    private function getRequestedPropertyStrategy()
    {
        return $this->consumePropertiesMapper->getRequestedPropertyStrategy($this->requestedRoute->getName());
    }
}