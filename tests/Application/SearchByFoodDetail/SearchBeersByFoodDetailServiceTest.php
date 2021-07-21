<?php

namespace App\Tests\Application\SearchByFoodDetail;

use App\Application\SearchByFood\SearchBeersByFoodService;
use App\Application\SearchByFoodDetail\SearchBeersByFoodDetailService;
use App\Domain\Model\Beer\BeerRepositoryInterface;
use App\Shared\Domain\Exception\RepositoryException;
use App\Shared\Domain\Exception\ServiceException;
use PHPUnit\Framework\TestCase;

class SearchBeersByFoodDetailServiceTest extends TestCase
{
    private SearchBeersByFoodDetailService $searchBeersByFoodDetailService;
    private BeerRepositoryInterface $beerRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->beerRepository = $this->createMock(BeerRepositoryInterface::class);
        $this->searchBeersByFoodDetailService = new SearchBeersByFoodDetailService($this->beerRepository);
    }

    public function testItReturnBeersFilteredByFood()
    {
        $this->beerRepository
            ->method('searchByFood')
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
                json_decode(
                    json_encode(
                        [
                            'id' => 3,
                            'name' => 'beer 2',
                            'tagline' => 'tagline 2',
                            'first_brewed' => '02/2021',
                            'description' => '2020 IPA',
                            'image_url' => 'https://images.punkapi.com/v2/174.png',
                            'abv' => 2.2,
                            'ibu' => 400,
                            'target_fg' => 1210,
                            'target_og' => 1264
                        ]
                    )
                )
            ]);

        $beers = $this->searchBeersByFoodDetailService->execute('chicken');

        $this->assertCount(2, $beers);

        $this->assertEquals(1, $beers[0]['id']);
        $this->assertEquals('beer 1', $beers[0]['name']);
        $this->assertEquals('2021 IPA', $beers[0]['description']);
        $this->assertEquals('https://images.punkapi.com/v2/173.png', $beers[0]['image']);
        $this->assertEquals('tagline', $beers[0]['tagline']);
        $this->assertEquals('01/2021', $beers[0]['first_brewed']);

        $this->assertEquals(3, $beers[1]['id']);
        $this->assertEquals('beer 2', $beers[1]['name']);
        $this->assertEquals('2020 IPA', $beers[1]['description']);
        $this->assertEquals('https://images.punkapi.com/v2/174.png', $beers[1]['image']);
        $this->assertEquals('tagline 2', $beers[1]['tagline']);
        $this->assertEquals('02/2021', $beers[1]['first_brewed']);
    }

    public function testItReturnEmptyBeers()
    {
        $this->beerRepository
            ->method('searchByFood')
            ->willReturn([]);

        $beers = $this->searchBeersByFoodDetailService->execute('chicken');

        $this->assertCount(0, $beers);
    }

    public function testItThrowsException()
    {
        $this->expectException(ServiceException::class);

        $this->beerRepository
            ->method('searchByFood')
            ->willThrowException(new RepositoryException());

        $this->searchBeersByFoodDetailService->execute('any');
    }
}
