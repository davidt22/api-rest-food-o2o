<?php

namespace App\Infrastructure\Service;

use App\Shared\Domain\Exception\ExternalAPIException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Request;

class RequestManager implements RequestManagerInterface
{
    const BASE_URL = 'https://api.punkapi.com/v2/beers';
    const APPLICATION_JSON = 'application/json';

    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     * @throws ExternalAPIException
     */
    public function get(array $params)
    {
        try {
            $uri = self::BASE_URL . '/';
            if ($this->isAssociative($params)) {
                $uri .= '?' . http_build_query($params);
            } else {
                $uri .= $params[0];
            }

            $options = [
                'headers' => [
                    'Content-Type' => self::APPLICATION_JSON,
                    'Accept' => self::APPLICATION_JSON
                ]
            ];

            $response = $this->client->request(Request::METHOD_GET, $uri, $options);
            $content = $response->getBody()->getContents();

            return json_decode($content);
        } catch (\Exception $exception) {
            throw new ExternalAPIException($exception->getMessage());
        }
    }

    private function isAssociative(array $array): bool
    {
        return ($array !== array_values($array));
    }
}