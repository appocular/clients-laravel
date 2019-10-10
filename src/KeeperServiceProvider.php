<?php

namespace Appocular\Clients;

use Appocular\Clients\Contracts\Keeper as KeeperContract;
use Appocular\Clients\Keeper;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class KeeperServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->configure('keeper');
        $this->app->singleton(KeeperContract::class, function ($app) {
            $uri = $app['config']->get('keeper.base_uri');
            $token = $app['config']->get('keeper.shared_token');
            $timeout = $app['config']->get('keeper.timeout', 5);
            if (empty($uri)) {
                throw new RuntimeException('No base uri for Keeper.');
            }
            $client = new Client(['base_uri' => $uri]);

            return new Keeper($token, $client, 5);
        });
    }
}
