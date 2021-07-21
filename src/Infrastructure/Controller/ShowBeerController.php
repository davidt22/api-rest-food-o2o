<?php

namespace App\Infrastructure\Controller;

use App\Application\GetById\GetByIdService;
use App\Shared\Domain\Exception\ServiceException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowBeerController
{
    public function show(int $id, GetByIdService $getByIdService): JsonResponse
    {
        try {
            $result = $getByIdService->execute($id);
        } catch (ServiceException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($result);
    }
}