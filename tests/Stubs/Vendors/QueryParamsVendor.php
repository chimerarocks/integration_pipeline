<?php
declare(strict_types=1);

namespace Test\Stubs\Vendors;

use Psr\Http\Message\ServerRequestInterface;
use Test\Stubs\Translators\PortalTranslator;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Vendor;

class QueryParamsVendor extends Vendor
{
    const BASE_URI = 'queryparamsvendor';

    public $baseURI = QueryParamsVendor::BASE_URI;

    public function queryParams(ServerRequestInterface $request): array
    {
        return [
            'userId' => $request->getAttribute('userId')
        ];
    }

    /**
     * @Consume
     * @Endpoint
     */
    public $condominios = PortalTranslator::class;

    public function condominiosQueryParams(ServerRequestInterface $request)
    {
        return [
            "ordenacao" => "ST_FANTASIA_COND%20ASC",
            "apenasOsQueTenhoAcesso" => "1",
            "somenteCondominiosAtivos" => "1",
            "itensPorPagina" => "50",
            "id" => "-1",
            "comDadosFechamento" => "1"
        ];
    }
}