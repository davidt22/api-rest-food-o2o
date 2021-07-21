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
        $this->assertEquals(1, $results[0]->id);
        $this->assertEquals('Buzz', $results[0]->name);
        $this->assertEquals('A light, crisp and bitter IPA brewed with English and American hops. A small batch brewed only once.', $results[0]->description);
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

    public function testFilterBeersByFoodDetailSuccess()
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_GET,
            '/food/detail/chicken'
        );

        $crawler = $client->getResponse()->getContent();

        $results = json_decode($crawler);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(25, $results);
        $this->assertEquals(1, $results[0]->id);
        $this->assertEquals('Buzz', $results[0]->name);
        $this->assertEquals('A light, crisp and bitter IPA brewed with English and American hops. A small batch brewed only once.', $results[0]->description);
        $this->assertEquals('https://images.punkapi.com/v2/keg.png', $results[0]->image);
        $this->assertEquals('A Real Bitter Experience.', $results[0]->tagline);
        $this->assertEquals('09/2007', $results[0]->first_brewed);
    }
}
