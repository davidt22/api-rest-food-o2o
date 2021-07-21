<?php

namespace App\Tests\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowBeerControllerTest extends WebTestCase
{
    public function testShowBeerDetailSuccess()
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_GET,
            '/show/1'
        );

        $crawler = $client->getResponse()->getContent();

        $results = json_decode($crawler);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $results->id);
        $this->assertEquals('Buzz', $results->name);
        $this->assertEquals('A light, crisp and bitter IPA brewed with English and American hops. A small batch brewed only once.', $results->description);
        $this->assertEquals('https://images.punkapi.com/v2/keg.png', $results->image);
        $this->assertEquals('A Real Bitter Experience.', $results->tagline);
        $this->assertEquals('09/2007', $results->first_brewed);
    }

    public function testShowBeerDetailError()
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_GET,
            '/show/0'
        );

        $crawler = $client->getResponse()->getContent();

        $results = json_decode($crawler);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
