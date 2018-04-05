<?php

namespace Ciromattia\Teamwork;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\ServiceProvider;

class TeamworkServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ciromattia.teamwork', function ($app) {
            $client = new \Ciromattia\Teamwork\Client(new Guzzle,
                $app['config']->get('services.teamwork.key'),
                $app['config']->get('services.teamwork.url')
            );

            return new \Ciromattia\Teamwork\Factory($client);
        });

        $this->app->bind('Ciromattia\Teamwork\Factory', 'ciromattia.teamwork');
    }
}