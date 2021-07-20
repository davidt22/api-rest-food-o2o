<?php

namespace App\Tests\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BeerControllerTest extends WebTestCase
{
    public function testFilterBeersByFoodSuccess()
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_GET,
            '/food/chicken'
        );

        $crawler = $client->getResponse()->getContent();

        $results = json_decode($crawler);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(25, $results);
    }

    public function testFilterBeersByFoodReturnsEmptyResults()
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_GET,
            '/food/aaaa'
        );

        $crawler = $client->getResponse()->getContent();

        $results = json_decode($crawler);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(0, $results);
    }
}
