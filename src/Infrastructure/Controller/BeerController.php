<?php

namespace App\Infrastructure\Controller;

use App\Application\SearchByFood\SearchBeersByFoodService;
use App\Shared\Domain\Exception\ServiceException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BeerController
{
    public function getByFood(string $value, SearchBeersByFoodService $searchBeersByFoodService): JsonResponse
    {
        try {
            $result = $searchBeersByFoodService->execute($value);
        } catch (ServiceException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($result);
    }
}