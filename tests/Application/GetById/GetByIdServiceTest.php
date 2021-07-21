<?php

namespace App\Tests\Application\GetById;

use App\Application\GetById\GetByIdService;
use App\Domain\Model\Beer\BeerRepositoryInterface;
use App\Shared\Domain\Exception\RepositoryException;
use App\Shared\Domain\Exception\ServiceException;
use PHPUnit\Framework\TestCase;

class GetByIdServiceTest extends TestCase
{
    private GetByIdService $getByIdService;
    private BeerRepositoryInterface $beerRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->beerRepository = $this->createMock(BeerRepositoryInterface::class);
        $this->getByIdService = new GetByIdService($this->beerRepository);
    }

    public function testItReturnBeersFilteredByFood()
    {
        $this->beerRepository
            ->method('getById')
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
                )
            ]);

        $beers = $this->getByIdService->execute(1);

        $this->assertEquals(1, $beers['id']);
        $this->assertEquals('beer 1', $beers['name']);
        $this->assertEquals('2021 IPA', $beers['description']);
        $this->assertEquals('https://images.punkapi.com/v2/173.png', $beers['image']);
        $this->assertEquals('tagline', $beers['tagline']);
        $this->assertEquals('01/2021', $beers['first_brewed']);
    }

    public function testItThrowsException()
    {
        $this->expectException(ServiceException::class);

        $this->beerRepository
            ->method('getById')
            ->willThrowException(new RepositoryException());

        $this->getByIdService->execute(1);
    }
}
