<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Facades\RequestMaker;

use Psr\Http\Message\ServerRequestInterface;
use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Services\Request\Facades\RequestMaker\IRequestMaker;
use Winker\IntegrationPipeline\Domain\Services\Request\IRequestFactory;

class RequestMakerTest extends TestCase
{
    /**
     * @var IRequestMaker $requestMaker
     */
    private $requestMaker;

    /**
     * @var IRequestFactory $requestMaker
     */
    private $requestFactory;

    public function setUp()
    {
        parent::setUp();
        $this->requestMaker = $this->container->get(IRequestMaker::class);
        $this->requestFactory = $this->container->get(IRequestFactory::class);
    }

    /**
     * @dataProvider validRequestsProvider
     * @param $uri
     * @param $method
     * @param $headers
     * @param $stream
     */
    public function test_can_make_request($uri, $method, $stream, $headers)
    {
        $request = $this->requestMaker
            ->make($uri, $method, $headers, $stream);

        $this->assertInstanceOf(ServerRequestInterface::class, $request);

        $newUri = $request->getUri();


        $expectedUri = $uri;
        $expectedMethod = $method;
        $expectedBody   = $stream;
        $expectedHeaders    = array_merge_recursive(
            IRequestFactory::DEFAULT_HEADERS,
            $headers
        );
        $expectedHeaders['Host'] = [$newUri->getAuthority()];


        $this->assertEquals($expectedUri, (string) $newUri, "uri should be equals");
        $this->assertEquals($expectedMethod, $request->getMethod(), "method should be equals");
        $this->assertEquals($expectedBody, (string) $request->getBody(), "body should be equals");
        $this->assertEquals($expectedHeaders, $request->getHeaders(), "headers should be equals");
    }

    /**
     * @return array
     */
    public function validRequestsProvider()
    {

        return [
            [ // query and uri and in queryParams
                'http://winker.com:8080/test/test?test=1#fragment',
                'GET',
                '{"field": "value"}',
                [
                    'Content-type' => ['application/json']
                ]
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