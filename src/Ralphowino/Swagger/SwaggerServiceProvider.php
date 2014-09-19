<?php namespace Ralphowino\Swagger;

use Illuminate\Support\ServiceProvider;
use Ralphowino\Swagger\Commands\SwaggerInitialize;


class SwaggerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    public function boot()
    {
        $this->package('ralphowino/swagger','swagger');
        include __DIR__ . '/../../routes.php';
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('ralphowino.swagger',function()
		{
            return new Swagger();
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
