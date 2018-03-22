<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Services\Vendor\Facades;

use Psr\Http\Message\ServerRequestInterface;
use Test\Stubs\Services\BankAccountService;
use Test\Stubs\Vendors\BasicVendor;
use Test\Stubs\Vendors\QueryParamsVendor;
use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Facade\IVendorFacade;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\ConsumePropertiesMapper;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IEndpointPropertyStrategy;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IServicePropertyStrategy;

class VendorFacadeTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_can_build_a_request_from_a_basic_vendor()
    {
        $this->stubProvider->fakeRequest(
            BasicVendor::class,
            'http://localhost' . ConsumePropertiesMapper::PORTAL_ROUTE,
            'GET',
            []
        );

        $vendorAdapter = $this->container->get(IVendorFacade::class);
        $request = $vendorAdapter->resolve();

        $this->assertInstanceOf(IPropertyStrategy::class, $request);
        $this->assertInstanceOf(IEndpointPropertyStrategy::class, $request);
    }

    public function test_can_make_a_service_from_basic_vendor()
    {
        $this->stubProvider->fakeRequest(
            BasicVendor::class,
            'http://localhost' . ConsumePropertiesMapper::BANK_ACCOUNTS_ROUTE,
            'GET',
            []
        );

        $this->container->bind('bancos', BankAccountService::class);

        $vendorFacade = $this->container->get(IVendorFacade::class);

        $service = $vendorFacade->resolve();

        $this->assertInstanceOf(IPropertyStrategy::class, $service);
        $this->assertInstanceOf(IServicePropertyStrategy::class, $service);
    }

    public function test_can_call_build_a_request_with_custom_query_params()
    {
        $this->stubProvider->fakeRequest(
            QueryParamsVendor::class,
            'http://localhost' . ConsumePropertiesMapper::PORTAL_ROUTE,
            'GET',
            [],
            '',
            ['userId' => '123']
        );

        $vendorFacade = $this->container->get(IVendorFacade::class);

        /* @var ServerRequestInterface $request */
        $request = $vendorFacade->resolve();

        $this->assertInstanceOf(IPropertyStrategy::class, $request);
        $this->assertInstanceOf(IEndpointPropertyStrategy::class, $request);
    }

    public function test_can_transform_data()
    {
        $this->stubProvider->fakeRequest(
            BasicVendor::class,
            'http://localhost' . ConsumePropertiesMapper::PORTAL_ROUTE,
            'GET',
            []
        );
        $vendorFacade = $this->container->get(IVendorFacade::class);

        $data = [
            'id_condominio_cond'        => 'test_id_condominio_cond',
            'st_fantasia_cond'          => 'test_st_fantasia_cond',
            'st_nome_cond'              => 'test_st_nome_cond',
            'st_cpf_cond'               => '1234',
            'st_telefone_cond'          => 'test_st_telefone_cond',
            'st_endereco_cond'          => 'test_st_endereco_cond',
            'st_complemento_cond'       => 'test_st_complemento_cond',
            'st_bairro_cond'            => 'test_st_bairro_cond',
            'st_cidade_cond'            => 'test_st_cidade_cond',
            'st_estado_cond'            => 'test_st_estado_cond',
            'st_cep_cond'               => '123456789',
            'st_email_cond'             => 'test_st_email_cond',
            'dt_diavencimento_cond'     => 'test_dt_diavencimento_cond'
        ];

        $expectedTransformedData = [
            'unique_id'                 => 'Portal:test_id_condominio_cond',
            'name'                      => 'test_st_fantasia_cond',
            'doc_cnpj'                  => '1234',
            'phone'                     => 'test_st_telefone_cond',
            'adress'                    => 'test_st_endereco_cond',
            'adress_complement'         => 'test_st_complemento_cond',
            'adress_neighborhood'       => 'test_st_bairro_cond',
            'adress_city'               => 'test_st_cidade_cond',
            'adress_state'              => 'test_st_estado_cond',
            'adress_zipcode'            => '123456789',
            'email_portal'              => 'test_st_email_cond',
            'billing_due_date'          => 'test_dt_diavencimento_cond'
        ];

        /* @var ServerRequestInterface $request */
        $transformedData = $vendorFacade->transformData($data);
        $this->assertEquals($expectedTransformedData, $transformedData);
    }
}