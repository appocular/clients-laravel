<?php

namespace Appocular\Clients;

use GuzzleHttp\Client;
use RuntimeException;

class Differ implements Contracts\Differ
{
    /**
     * HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Construct Differ client.
     *
     * @param Client $client
     *   HTTP client to use.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function submit(string $image_kid, string $baseline_kid) : void
    {
        $json = ['image_kid' => $image_kid, 'baseline_kid' => $baseline_kid];
        $response = $this->client->post('diff', ['json' => $json]);
        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException('Bad response from Differ.');
        }
    }
}
