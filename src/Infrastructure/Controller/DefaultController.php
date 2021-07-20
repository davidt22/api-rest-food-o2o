<?php

namespace App\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController
{
    public function demo(): JsonResponse
    {
        return new JsonResponse('Hola');
    }
}