<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Pipes;

use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Facade\IVendorFacade;

class TransformPipe implements ITransformPipe
{
    /**
     * @var IVendorFacade
     */
    private $vendorFacade;

    public function __construct(IVendorFacade $vendorFacade)
    {
        $this->vendorFacade = $vendorFacade;
    }

    public function handle(ServerRequestInterface $request, \Closure $next)
    {
        $data = $request->getAttribute(IConsumePipe::class);
        $transformedData = $this->vendorFacade->transformData($data);
        $request = $request->withAttribute(ITransformPipe::class, $transformedData);
        return $next($request);
    }
}