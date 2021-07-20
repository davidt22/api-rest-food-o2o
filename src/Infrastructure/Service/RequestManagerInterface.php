<?php


namespace App\Infrastructure\Service;


interface RequestManagerInterface
{
    public function get(array $params);
}