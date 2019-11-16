<?php

declare(strict_types=1);

namespace Appocular\Clients;

use Appocular\Clients\Contracts\Keeper as KeeperContract;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class KeeperServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register(): void
    {
        $this->app->configure('keeper');
        $this->app->singleton(KeeperContract::class, static function ($app): KeeperContract {
            $uri = $app['config']->get('keeper.base_uri');
            $token = $app['config']->get('keeper.shared_token');
            $timeout = (int) $app['config']->get('keeper.timeout', 5);

            if ($timeout < 1) {
                $timeout = 5;
            }

            if (!$uri) {
                throw new RuntimeException('No base uri for Keeper.');
            }

            $client = new Client(['base_uri' => $uri]);

            return new Keeper($token, $client, $timeout);
        });
    }
}
