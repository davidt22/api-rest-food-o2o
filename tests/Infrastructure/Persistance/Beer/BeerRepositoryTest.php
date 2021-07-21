<?php

namespace App\Tests\Infrastructure\Persistance\Beer;

use App\Domain\Model\Beer\BeerRepositoryInterface;
use App\Infrastructure\Persistance\Beer\BeerRepository;
use App\Infrastructure\Service\RequestManagerInterface;
use App\Shared\Domain\Exception\RepositoryException;
use PHPUnit\Framework\TestCase;

class BeerRepositoryTest extends TestCase
{
    private RequestManagerInterface $requestManager;
    private BeerRepositoryInterface $beerRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->requestManager = $this->createMock(RequestManagerInterface::class);
        $this->beerRepository = new BeerRepository($this->requestManager);
    }

    public function testItReturnsDataSuccessful()
    {
        $this->requestManager
            ->method('get')
            ->willReturn([
                json_decode(
                    json_encode(
                        [
                            'id' => 1,
                            'name' => 'beer 1',
                            'tagline' => 'tagline',
                            'first_brewed' => '01/2021',
                            'description' => '2021 IPA',
                            'image_url' => 'https://images.punkapi.com/v2/173.png',
                            'abv' => 7.2,
                            'ibu' => 100,
                            'target_fg' => 1010,
                            'target_og' => 1064
                        ]
                    )
                ),
        ]);

        $results = $this->beerRepository->searchByFood('food');

        $this->assertGreaterThan(0, count($results));
    }

    public function testItReturnsEmptyData()
    {
        $this->requestManager
            ->method('get')
            ->willReturn([]);

        $results = $this->beerRepository->searchByFood('food');

        $this->assertEquals(0, count($results));
    }

    public function testItThrowsExcption()
    {
        $this->expectException(RepositoryException::class);

        $this->requestManager
            ->method('get')
            ->willThrowException(new \Exception());

        $this->beerRepository->searchByFood('food');
    }
}
