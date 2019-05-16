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
    public function reportDiff(string $image_kid, string $baseline_kid, string $diff_kid, bool $different) : void
    {
        $json = [
            'image_kid' => $image_kid,
            'baseline_kid' => $baseline_kid,
            'diff_kid' => $diff_kid,
            'different' => $different,
        ];
        $response = $this->client->post('diff', ['json' => $json]);
        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException('Bad response from Assessor.');
        }
    }
}
