<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Services\Request;

use Psr\Http\Message\UriInterface;
use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Services\Request\Exceptions\InvalidUriFormatException;
use Winker\IntegrationPipeline\Domain\Services\Request\IUriFactory;

class UriFactoryTest extends TestCase
{
    /**
     * @dataProvider validUrisProvider
     * @param $uri
     * @param $expectedScheme
     * @param $expectedHost
     * @param $expectedPort
     * @param $expectedPath
     * @param $expectedQuery
     * @param $expectedFragment
     * @throws InvalidUriFormatException
     */
    public function test_can_create_uri(
        $uri,
        $expectedScheme,
        $expectedHost,
        $expectedPort,
        $expectedPath,
        $expectedQuery,
        $expectedFragment
    )
    {
        /* @var IUriFactory $uriFactory*/
        $uriFactory = $this->container->get(IUriFactory::class);
        $parsedUri = $uriFactory->make($uri);
        $this->assertInstanceOf(UriInterface::class, $parsedUri);
        $this->assertEquals($expectedScheme, $parsedUri->getScheme(), "scheme should be equals '$expectedScheme'");
        $this->assertEquals($expectedHost, $parsedUri->getHost(), "host should be equals $expectedHost");
        $this->assertEquals($expectedPort, $parsedUri->getPort(), "port should be equals $expectedPort");
        $this->assertEquals($expectedPath, $parsedUri->getPath(), "path should be equals $expectedPath");
        $this->assertEquals($expectedQuery, $parsedUri->getQuery(), "query should be equals $expectedQuery");
        $this->assertEquals($expectedFragment, $parsedUri->getFragment(),  "fragment should be equals $expectedFragment");
    }

    public function validUrisProvider()
    {
        return [
            [ // uri without scheme should return http scheme as default
                'winker.com.br/test?id=1#target',
                'http',
                'winker.com.br',
                null,
                '/test',
                'id=1',
                'target'
            ],
            [ // complete uri
                'http://winker.com.br/test?id=1#target',
                'http',
                'winker.com.br',
                null,
                '/test',
                'id=1',
                'target'
            ],
            [ // complete uri + port
                'http://winker.com.br:8080/test?id=1#target',
                'http',
                'winker.com.br',
                '8080',
                '/test',
                'id=1',
                'target'
            ],
            [ // complete uri + many query params
                'http://winker.com.br:123/test?id=1&p1=3&p3=8#target',
                'http',
                'winker.com.br',
                '123',
                '/test',
                'id=1&p1=3&p3=8',
                'target'
            ],
            [ // complete uri + many paths
                'http://winker.com.br:1234/path1/path2?id=1&p1=3&p3=8#target',
                'http',
                'winker.com.br',
                '1234',
                '/path1/path2',
                'id=1&p1=3&p3=8',
                'target'
            ],
            [ // complete uri + slash after path
                'http://winker.com.br:12345/path1/?id=1&p1=3&p3=8#target',
                'http',
                'winker.com.br',
                '12345',
                '/path1/',
                'id=1&p1=3&p3=8',
                'target'
            ],
            [ // only scheme and host
                'http://winker.com.br',
                'http',
                'winker.com.br',
                null,
                null,
                null,
                null
            ],
            [ // only scheme, host and port
                'http://winker.com.br:1',
                'http',
                'winker.com.br',
                '1',
                null,
                null,
                null
            ],
            [ // uri without path
                'http://winker.com.br?id=1#target',
                'http',
                'winker.com.br',
                null,
                null,
                'id=1',
                'target'
            ],
            [ // uri without path with port
                'http://winker.com.br:8080?id=1#target',
                'http',
                'winker.com.br',
                '8080',
                null,
                'id=1',
                'target'
            ],
            [ // uri without path and fragment with query
                'http://winker.com.br?id=1',
                'http',
                'winker.com.br',
                null,
                null,
                'id=1',
                null
            ],
            [ // uri without path and query with fragment
                'http://winker.com.br:8080#target',
                'http',
                'winker.com.br',
                '8080',
                null,
                null,
                'target'
            ]
        ];
    }

}