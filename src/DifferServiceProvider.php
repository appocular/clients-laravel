<?php

declare(strict_types=1);

namespace Appocular\Clients;

use Appocular\Clients\Contracts\Differ as DifferContract;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class DifferServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register(): void
    {
        $this->app->configure('differ');
        $this->app->singleton(DifferContract::class, static function ($app): DifferContract {
            $uri = $app['config']->get('differ.base_uri');
            $token = $app['config']->get('differ.shared_token');
            $timeout = (int) $app['config']->get('differ.shared_token', 5);

            if ($timeout < 1) {
                $timeout = 5;
            }

            if (!$uri) {
                throw new RuntimeException('No base uri for Differ.');
            }

            $client = new Client(['base_uri' => $uri]);

            return new Differ($token, $client, $timeout);
        });
    }
}
