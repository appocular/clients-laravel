<?php

namespace Appocular\Clients;

use GuzzleHttp\Client;
use RuntimeException;

class Keeper implements Contracts\Keeper
{

    /**
     * HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Construct image store.
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
    public function store(string $data) : string
    {
        $response = $this->client->post('image', ['body' => $data]);
        $reply = json_decode($response->getBody());
        if ($response->getStatusCode() !== 200 || !property_exists($reply, 'sha')) {
            throw new RuntimeException('Bad response from Keeper.');
        }
        return $reply->sha;
    }

    /**
     * {@inheritdoc}
     */
    public function get($kid) : ?string
    {
        try {
            $response = $this->client->get('image/' . $kid);
            if ($response->getStatusCode() == 200) {
                return $response->getBody();
            }
        } catch (\Exception $e) {
            // On any error return nothing.
        }
        return null;
    }
}
