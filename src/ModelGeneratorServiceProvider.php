<?php namespace Laracademy\ModelGenerator;

/**
 *
 * @author Michael McMullen <michael@laracademy.co>
 */

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ModelGeneratorServiceProvider extends ServiceProvider{


    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        //
    }


    public function register()
    {
        $this->registerModelGenerator();
    }

    private function registerModelGenerator()
    {
        $this->app->singleton('command.laracademy.generate', function($app) {
            return $app['Laracademy\ModelGenerator\Commands\ModelGenerateCommand'];
        });

        $this->commands('command.laracademy.generate');
    }
}