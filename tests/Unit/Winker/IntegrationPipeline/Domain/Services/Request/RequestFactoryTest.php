<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Services\Request;

use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Services\Request\IRequestFactory;
use Winker\IntegrationPipeline\Domain\Services\Request\IStreamFactory;
use Winker\IntegrationPipeline\Domain\Services\Request\IUriFactory;
use Winker\IntegrationPipeline\Domain\Services\Request\RequestFactory;

class RequestFactoryTest extends TestCase
{
    /**
     * @var RequestFactory $requestFactory
     */
    private $requestFactory;

    public function setUp()
    {
        parent::setUp();
        $this->requestFactory = $this->container->get(IRequestFactory::class);
    }


    /**
     * @dataProvider validRequestsProvider
     * @param string $uri
     * @param string $method
     * @param string $body
     * @param array $headers
     * @param array $queryParams
     */
    public function test_can_make_request(string $uri, string $method, string $body = null, array $headers = [], array $queryParams = [])
    {
        /* @var IUriFactory $uriFactory */
        $uriFactory = $this->container->get(IUriFactory::class);
        $newUri        = $uriFactory->make($uri);

        /** @var IStreamFactory $streamFactory */
        $streamFactory = $this->container->get(IStreamFactory::class);
        $stream        = $streamFactory->make($body);

        $request = $this->requestFactory->make($newUri, $method, $headers, $stream, $queryParams);

        $expectedHeaders    = array_merge_recursive(
            IRequestFactory::DEFAULT_HEADERS,
            $headers
        );
        $expectedHeaders['Host'] = [$newUri->getAuthority()];

        $expectedMethod = $method;
        $expectedBody   = $body;
        $expectedQueryParams = $queryParams;

        $this->assertEquals($uri, (string) $request->getUri());
        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertEquals($expectedBody, (string) $request->getBody());
        $this->assertEquals($expectedHeaders, $request->getHeaders());
        $this->assertEquals($expectedQueryParams, $request->getQueryParams());
    }

    /**
     * @return array
     */
    public function validRequestsProvider()
    {

        return [
            [ // uri with query params
                'http://winker.com?userId=123',
                'GET',
                '',
                []
            ],
            [ // post json
                'http://winker.com:8080/test/test?test=1#fragment',
                'POST',
                '{"field": "value"}',
                [
                    'Content-type' => ['application/json']
                ]
            ],
            [ // only uri and method
                'http://winker.com',
                'GET',
                null,
                []
            ],
            [ // only uri, method and port
                'http://winker.com:8080',
                'GET',
                null,
                []
            ],
            [ // only uri, method, port, path
                'http://winker.com:8080/test',
                'GET',
                null,
                []
            ],
            [ // only uri, method, port, path, query
                'http://winker.com:8080/test?test=1',
                'GET',
                null,
                []
            ],
            [ // only uri, method, port, path, query, fragment
            'http://winker.com:8080/test/test?test=1#fragment',
                'GET',
                null,
                []
            ],

        ];
    }
}