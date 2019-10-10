<?php

namespace Appocular\Clients;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Appocular\Clients\Contracts\Assessor as AssessorContract;
use Appocular\Clients\Assessor;
use RuntimeException;

class AssessorServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->configure('assessor');
        $this->app->singleton(AssessorContract::class, function ($app) {
            $uri = $app['config']->get('assessor.base_uri');
            $token = $app['config']->get('assessor.shared_token');
            $timeout = $app['config']->get('assessor.timeout', 5);
            if (empty($uri)) {
                throw new RuntimeException('No base uri for Assessor.');
            }
            $client = new Client(['base_uri' => $uri]);

            return new Assessor($token, $client, $timeout);
        });
    }
}
