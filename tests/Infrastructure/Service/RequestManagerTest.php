<?php

namespace App\Tests\Infrastructure\Service;

use App\Infrastructure\Service\RequestManager;
use App\Shared\Domain\Exception\ExternalAPIException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

class RequestManagerTest extends TestCase
{
    private RequestManager $requestManager;
    private ClientInterface $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(ClientInterface::class);
        $this->requestManager = new RequestManager($this->client);
    }

    public function testGetMethodAssociativeIsSuccessful()
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream
            ->method('getContents')
            ->willReturn('
                {
                    "id": 173,
                    "name": "Chinook - IPA Is Dead",
                    "tagline": "Single Hop India Pale Ale."
                }
            ');

        $response = $this->createMock(Response::class);

        $response
            ->method('getBody')
            ->willReturn($stream);

        $this->client
            ->method('request')
            ->willReturn($response);

        $result = $this->requestManager->get([
            'food' => 'chicken'
        ]);

        $this->assertEquals(173, $result->id);
        $this->assertEquals('Chinook - IPA Is Dead', $result->name);
        $this->assertEquals('Single Hop India Pale Ale.', $result->tagline);
    }

    public function testGetMethodSequentialIsSuccessful()
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream
            ->method('getContents')
            ->willReturn('
                {
                    "id": 1,
                    "name": "Skull - IPA Is Dead",
                    "tagline": "Single Hop Skull Ale."
                }
            ');

        $response = $this->createMock(Response::class);

        $response
            ->method('getBody')
            ->willReturn($stream);

        $this->client
            ->method('request')
            ->willReturn($response);

        $result = $this->requestManager->get([
            1
        ]);

        $this->assertEquals(1, $result->id);
        $this->assertEquals('Skull - IPA Is Dead', $result->name);
        $this->assertEquals('Single Hop Skull Ale.', $result->tagline);
    }

    public function testGetMethodThrowsException()
    {
        $this->expectException(ExternalAPIException::class);

        $this->client
            ->method('request')
            ->willThrowException(new \Exception());

        $this->requestManager->get([]);
    }
}
