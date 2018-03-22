<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Pipes;

use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Services\Consumer\ConsumerChain;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Facade\IVendorFacade;

class ConsumePipe implements IConsumePipe
{

    /**
     * @var ConsumerChain
     */
    private $consumer;
    /**
     * @var IVendorFacade
     */
    private $vendorFacade;

    public function __construct(
        ConsumerChain $consumer,
        IVendorFacade $vendorFacade
    )
    {
        $this->consumer = $consumer;
        $this->vendorFacade = $vendorFacade;
    }

    public function handle(ServerRequestInterface $request, \Closure $next)
    {
        $propertyStrategy = $this->vendorFacade->resolve();
        $result = $this->consumer->consume($propertyStrategy);
        $request = $request->withAttribute(IConsumePipe::class, $result);
        return $next($request);
    }
}