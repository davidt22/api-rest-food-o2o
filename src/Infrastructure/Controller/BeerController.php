<?php

namespace App\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController
{
    public function demo(string $name): JsonResponse
    {
        var_dump($name);
        die;
        return new JsonResponse('Hola');
    }
}