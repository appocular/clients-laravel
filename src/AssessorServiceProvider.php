<?php

declare(strict_types=1);

namespace Appocular\Clients;

use Appocular\Clients\Contracts\Assessor as AssessorContract;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class AssessorServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register(): void
    {
        $this->app->configure('assessor');
        $this->app->singleton(AssessorContract::class, static function ($app): AssessorContract {
            $uri = $app['config']->get('assessor.base_uri');
            $token = $app['config']->get('assessor.shared_token');
            $timeout = (int) $app['config']->get('assessor.timeout', 5);

            if ($timeout < 1) {
                $timeout = 5;
            }

            if (!$uri) {
                throw new RuntimeException('No base uri for Assessor.');
            }

            $client = new Client(['base_uri' => $uri]);

            return new Assessor($token, $client, $timeout);
        });
    }
}
