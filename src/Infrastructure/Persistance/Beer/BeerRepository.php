<?php

namespace App\Infrastructure\Persistance\Beer;

use App\Domain\Model\Beer\BeerRepositoryInterface;
use App\Infrastructure\Service\RequestManagerInterface;
use App\Shared\Domain\Exception\RepositoryException;

class BeerRepository implements BeerRepositoryInterface
{
    private RequestManagerInterface $requestManager;

    public function __construct(RequestManagerInterface $requestManager)
    {
        $this->requestManager = $requestManager;
    }

    /**
     * @throws RepositoryException
     */
    public function searchByFood(string $food)
    {
        try {
            return $this->requestManager->get([
                'food' => $food
            ]);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }
}