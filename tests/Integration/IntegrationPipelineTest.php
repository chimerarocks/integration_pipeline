<?php
declare(strict_types=1);

namespace Test\Integration;

use Test\Stubs\Services\HttpClient;
use Test\Stubs\Vendors\BasicVendor;
use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Contracts\IntegrationPipelineContract;
use Winker\IntegrationPipeline\Domain\Services\HttpClient\IHttpClient;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\ConsumePropertiesMapper;

class IntegrationPipelineTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_translation_to_portal()
    {
        /**
         * @var IntegrationPipelineContract $integrationPipeline
         */
        $integrationPipeline = $this->container
            ->get(IntegrationPipelineContract::class);

        $this->stubProvider->fakeRequest(
          BasicVendor::class,
          'http://localhost' . ConsumePropertiesMapper::PORTAL_ROUTE,
          'GET',
          []
        );

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



        $this->container->bind(IHttpClient::class, function() use ($data) {
            $client = new HttpClient($data);
            return $client;
        });

        $result = $integrationPipeline->process();

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

        $this->assertEquals($expectedTransformedData, $result);
    }
}