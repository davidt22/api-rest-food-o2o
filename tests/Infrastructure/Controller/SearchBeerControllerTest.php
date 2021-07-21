<?php

namespace App\Tests\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class SearchBeerControllerTest extends WebTestCase
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
}
