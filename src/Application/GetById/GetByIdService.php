<?php

namespace App\Application\GetById;

use App\Domain\Model\Beer\BeerRepositoryInterface;
use App\Shared\Domain\Exception\RepositoryException;
use App\Shared\Domain\Exception\ServiceException;

class GetByIdService
{
    private BeerRepositoryInterface $beerRepository;

    public function __construct(BeerRepositoryInterface $beerRepository)
    {
        $this->beerRepository = $beerRepository;
    }

    /**
     * @throws ServiceException
     */
    public function execute(int $id): array
    {
        try {
            $beer = $this->beerRepository->getById($id);

            if (count($beer) === 1) {
                $beer = $this->simplify($beer[0]);
            }

            return $beer;
        } catch (RepositoryException $exception) {
            throw new ServiceException($exception->getMessage());
        }
    }

    private function simplify(\stdClass $beer): array
    {
        return [
            'id' => $beer->id,
            'name' => $beer->name,
            'description' => $beer->description,
            'image' => $beer->image_url,
            'tagline' => $beer->tagline,
            'first_brewed' => $beer->first_brewed
        ];
    }
}