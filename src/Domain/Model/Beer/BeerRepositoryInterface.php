<?php

namespace App\Domain\Model\Beer;

use App\Shared\Domain\Exception\RepositoryException;

interface BeerRepositoryInterface
{
    /**
     * @throws RepositoryException
     */
    public function searchByFood(string $food);
}