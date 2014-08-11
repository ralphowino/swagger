<?php namespace Ralphowino\Swagger;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD
use Ralphowino\Swagger\Commands\SwaggerInitialize;
=======
>>>>>>> 3ce400a786303ad2458bcc4c64fdda09cec523d0

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
<<<<<<< HEAD
        $this->registerCommands();
=======
>>>>>>> 3ce400a786303ad2458bcc4c64fdda09cec523d0
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

<<<<<<< HEAD
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

=======
>>>>>>> 3ce400a786303ad2458bcc4c64fdda09cec523d0
}
