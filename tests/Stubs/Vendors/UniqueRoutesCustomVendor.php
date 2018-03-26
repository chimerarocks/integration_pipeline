<?php
declare(strict_types=1);

namespace Test\Stubs\Vendors;

use Psr\Http\Message\ServerRequestInterface;
use Test\Stubs\Translators\PortalTranslator;
use Winker\Integration\Util\Model\Translation\Model\BankAccount;
use Winker\Integration\Util\Model\Translation\Model\BillingUnit;
use Winker\Integration\Util\Model\Translation\Model\Unit;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Vendor;

class UniqueRoutesCustomVendor extends Vendor
{
    const BASE_URI = 'uniqueroutescustomvendor';

    public $baseURI = UniqueRoutesCustomVendor::BASE_URI;

    /**
     * @Consume
     * @Endpoint
     */
    public $unidades = Unit::class;

    /**
     * @Consume
     * @Endpoint
     * @Read=/test/@Id
     */
    public $condominios = PortalTranslator::class;

    /**
     * @Consume
     * @Endpoint
     * @Collection=/test
     * @ByPortal=/test?portalId=@Id
     */
    public $bancos = BankAccount::class;

    /**
     * @Consume
     * @Endpoint
     * @Read=/test?portalId=@Id
     */
    public $cobrancas = BillingUnit::class;

    public function cobrancasQueryParams(ServerRequestInterface $request)
    {
        return [
            'queryParam' => 1
        ];
    }
}