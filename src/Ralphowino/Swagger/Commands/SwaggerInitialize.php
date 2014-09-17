<?php namespace Ralphowino\Swagger\Commands;

use Illuminate\Console\Command;
use Ralphowino\Swagger\Swagger;
use Symfony\Component\Console\Input\InputArgument;

class SwaggerInitialize extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'swagger:init';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $swg = new \Ralphowino\Swagger\Swagger();
        $swg->api('index')
            ->apiVersion(\Config::get('swagger::api.version'))
            ->swaggerVersion(Swagger::config('version'))
            ->basePath(url(\Config::get('swagger::docs.route')))
            ->info(\Config::get('swagger::docs.info'));
        $this->info('Swagger Initialized');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('api_version', InputArgument::OPTIONAL, 'Version of the API','1.0.0'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}