<?php

namespace Appocular\Clients;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Appocular\Clients\Contracts\Differ as DifferContract;
use Appocular\Clients\Differ;
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
            if (empty($uri)) {
                throw new RuntimeException('No base uri for Differ.');
            }
            $client = new Client(['base_uri' => $uri]);

            return new Differ($client);
        });
    }
}
