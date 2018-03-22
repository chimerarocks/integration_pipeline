<?php
declare(strict_types=1);

namespace Test\Stubs\Vendors;

use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Contracts\IVendor;

class ArrayStrategyIVendor implements IVendor
{
    private $headers;

    public function __construct(
        array $headers = ['Content-type' => 'application/json'],
        string $baseURI,
        array $fields = [
            'condominios' => [
                'consumeMethod' => 'GET',
                'produceMethod' => 'POST',
                'mapping' => [
                    CondominioMapping::class =>
                        Portal::class
                ],
                'namespace' => ['*.condominios']
            ]
        ])
    {
        $this->headers = $headers;
        $this->baseURI = $baseURI;
        $this->fields = $fields;
        foreach ($fields as $field => $mapping) {
            $this->$field = $mapping;
        }
    }

    public function headers(ServerRequestInterface $request)
    {
        return $this->headers;
    }

    public $baseURI = 'http://test.com';
}