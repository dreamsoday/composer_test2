<?php
namespace Lgy\Test;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider {
    protected $defer = true;

    public function boot() {

        $this->publishes([
            __DIR__.'/../config/test.php' => config_path('test.php'),
        ], 'test');
    }

    public function register() {
        $this->mergeConfigFrom( __DIR__.'/../config/test.php', 'test');

        $this->app->singleton('test', function($app) {
            $config = $app->make('config');

            $client_id = $config->get('test.client_id');
            $client_secret = $config->get('test.client_secret');
            $app_name = $config->get('test.app_name');
            $org_name = $config->get('test.org_name');
            if (!empty ($org_name) && !empty ($app_name)) {
                $url = 'http://a1.easemob.com/' . $org_name . '/' . $app_name . '/';
            }

            return new TestService($client_id, $client_secret, $app_name, $org_name, $url);
        });
    }

    public function provides() {
        return ['test'];
    }
}
