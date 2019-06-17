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
    public function submit(string $image_url, string $baseline_url) : void
    {
        $json = ['image_url' => $image_url, 'baseline_url' => $baseline_url];
        $response = $this->client->post('diff', ['json' => $json, 'timeout' => 5]);
        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException('Bad response from Differ.');
        }
    }
}
