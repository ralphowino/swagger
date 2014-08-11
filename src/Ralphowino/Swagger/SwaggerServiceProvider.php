<?php namespace Ralphowino\Swagger;

use Illuminate\Support\ServiceProvider;
use Ralphowino\Swagger\Commands\SwaggerInitialize;

class SwaggerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('swagger',function(){
            return new \Ralphowino\Swagger\Swagger();
        });
        $this->registerCommands();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

    private function registerCommands()
    {
        $commands = array(
            'swagger.init' => 'Ralphowino\Swagger\Commands\SwaggerInitialize',
            'swagger.generate' => 'Ralphowino\Swagger\Commands\SwaggerGenerate',
        );
        foreach($commands as $key => $command)
        {
            $this->app->bind($key,function($app) use($command)
            {
                return new $command();
            });
            $this->commands($key);
        }

    }

}
