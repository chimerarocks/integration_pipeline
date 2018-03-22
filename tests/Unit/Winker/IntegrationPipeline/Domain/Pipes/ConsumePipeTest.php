<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Pipes;

use Psr\Http\Message\ServerRequestInterface;
use Test\Stubs\Services\HttpClient;
use Test\Stubs\Vendors\BasicVendor;
use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Pipes\IConsumePipe;
use Winker\IntegrationPipeline\Domain\Services\HttpClient\IHttpClient;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\ConsumePropertiesMapper;

class ConsumePipeTest extends TestCase
{
    private $requestMaker;

    public function setUp()
    {
        parent::setUp();
    }

    public function test_can_handle_a_basic_vendor()
    {
        $this->stubProvider->fakeRequest(
            BasicVendor::class,
            'http://localhost' . ConsumePropertiesMapper::PORTAL_ROUTE,
            'GET',
            [],
            '',
            [ 'userId' => 123 ]
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

        $pipe = $this->container->get(IConsumePipe::class);
        $request = $this->container->get(ServerRequestInterface::class);

        $result = $pipe->handle($request, function(ServerRequestInterface $request) {
            return $request->getAttribute(IConsumePipe::class);
        });

        $this->assertEquals($data, $result);
    }
}