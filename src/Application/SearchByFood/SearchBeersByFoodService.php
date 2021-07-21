<?php

namespace App\Application\SearchByFood;

use App\Domain\Model\Beer\BeerRepositoryInterface;
use App\Shared\Domain\Exception\RepositoryException;
use App\Shared\Domain\Exception\ServiceException;

class SearchBeersByFoodService
{
    private BeerRepositoryInterface $beerRepository;

    public function __construct(BeerRepositoryInterface $beerRepository)
    {
        $this->beerRepository = $beerRepository;
    }

    /**
     * @throws ServiceException
     */
    public function execute(string $food): array
    {
        try {
            $beersResults = $this->beerRepository->searchByFood($food);

            return $this->simplify($beersResults);
        } catch (RepositoryException $exception) {
            throw new ServiceException($exception->getMessage());
        }
    }

    private function simplify(array $beersResults): array
    {
        $beers = [];
        foreach ($beersResults as $elem) {
            $beer = [
                'id' => $elem->id,
                'name' => $elem->name,
                'description' => $elem->description,
            ];
            array_push($beers, $beer);
        }

        return $beers;
    }
}