<?php
declare(strict_types=1);

namespace Test\Stubs\Vendors;

use Psr\Http\Message\ServerRequestInterface;
use Test\Stubs\Translators\BankAccountTranslator;
use Test\Stubs\Translators\PortalTranslator;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Vendor;

class BasicVendor extends Vendor
{
    const BASE_URI = 'basicvendor';

    public $baseURI = BasicVendor::BASE_URI;

    /**
     * @Consume
     * @Endpoint
     */
    public $condominios = PortalTranslator::class;

    public function condominioQueryParams(ServerRequestInterface $request)
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

    /**
     * @Consume
     * @Service
     */
    public $bancos = BankAccountTranslator::class;

    public $notConsume;
}