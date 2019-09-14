<?php

namespace Appocular\Clients;

use GuzzleHttp\Client;
use RuntimeException;

class Keeper implements Contracts\Keeper
{
    /**
     * Authorization token.
     *
     * @var string
     */
    protected $token;

    /**
     * HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Construct Keeper client.
     *
     * @param string $token
     *   Authorisation token.
     * @param Client $client
     *   HTTP client to use.
     */
    public function __construct(string $token, Client $client)
    {
        $this->token = $token;
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function store(string $data) : string
    {
        $headers = ['Authorization' => 'Bearer ' . $this->token];
        $response = $this->client->post('image', ['body' => $data, 'timeout' => 5, 'headers' => $headers]);
        $location = $response->getHeader('Location');
        if ($response->getStatusCode() !== 201 || count($location) != 1) {
            throw new RuntimeException('Bad response from Keeper.');
        }
        return $location[0];
    }

    /**
     * {@inheritdoc}
     */
    public function get($url) : ?string
    {
        try {
            // As the ID is the URL of the image, just pass it to Guzzle.
            $response = $this->client->get($url, [ 'timeout' => 5]);
            if ($response->getStatusCode() == 200) {
                return $response->getBody();
            }
        } catch (\Exception $e) {
            // On any error return nothing.
        }
        return null;
    }
}
