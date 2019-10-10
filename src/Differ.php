<?php

namespace Appocular\Clients;

use GuzzleHttp\Client;
use RuntimeException;

class Differ implements Contracts\Differ
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
     * Request timeout.
     *
     * @var int
     */
    protected $timeout;

    /**
     * Construct Differ client.
     *
     * @param string $token
     *   Authorisation token.
     * @param Client $client
     *   HTTP client to use.
     * @param int $timeout
     *   Request timeout.
     */
    public function __construct(string $token, Client $client, int $timeout = 5)
    {
        $this->token = $token;
        $this->client = $client;
        $this->timeout = $timeout;
    }

    /**
     * {@inheritdoc}
     */
    public function submit(string $image_url, string $baseline_url): void
    {
        $headers = ['Authorization' => 'Bearer ' . $this->token];
        $json = ['image_url' => $image_url, 'baseline_url' => $baseline_url];
        $response = $this->client->post('diff', ['json' => $json, 'timeout' => $this->timeout, 'headers' => $headers]);
        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException('Bad response from Differ.');
        }
    }
}
