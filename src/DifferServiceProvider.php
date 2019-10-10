<?php

namespace Appocular\Clients;

use Appocular\Clients\Contracts\Differ as DifferContract;
use Appocular\Clients\Differ;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class DifferServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->configure('differ');
        $this->app->singleton(DifferContract::class, function ($app) {
            $uri = $app['config']->get('differ.base_uri');
            $token = $app['config']->get('differ.shared_token');
            $timeout = $app['config']->get('differ.shared_token', 5);
            if (empty($uri)) {
                throw new RuntimeException('No base uri for Differ.');
            }
            $client = new Client(['base_uri' => $uri]);

            return new Differ($token, $client, $timeout);
        });
    }
}
