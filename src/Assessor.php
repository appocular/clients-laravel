<?php

namespace Appocular\Clients;

use GuzzleHttp\Client;
use RuntimeException;

class Assessor implements Contracts\Assessor
{
    /**
     * HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Construct Appocular client.
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
    public function reportDiff(string $image_url, string $baseline_url, string $diff_url, bool $different) : void
    {
        $json = [
            'image_url' => $image_url,
            'baseline_url' => $baseline_url,
            'diff_url' => $diff_url,
            'different' => $different,
        ];
        $response = $this->client->post('diff', ['json' => $json, 'timeout' => 5]);
        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException('Bad response from Assessor.');
        }
    }
}
