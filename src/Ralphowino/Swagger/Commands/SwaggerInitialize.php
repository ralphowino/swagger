<?php namespace Ralphowino\Swagger\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;
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
	protected $description = 'Publish files and initialize your swagger instance';



    protected $commands = array(
        '4' => array(
            'publish-views' => 'views:publish',
            'publish-config' => 'config:publish',
            'publish-assets' => 'assets:publish',
        ),
        '5' => array(
            'publish-views' => 'publish:views',
            'publish-config' => 'publish:config',
            'publish-assets' => 'publish:assets',
        )
    );
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
        $this->commands = $this->commands[substr(Application::VERSION,0,1)];
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        //publish resources
        $this->publishViews();
        $this->publishConfig();
        $this->publishAssets();
        $this->info('Creating base doc');
        $swg = new Swagger();
        $swg->api('index')
            ->basePath(url(Config::get('swagger::docs.route')));
        $this->info('Swagger Initialized. You can access it at /'.\Config::get('swagger::docs.route'));
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

    protected function publishViews()
    {
        $publish = $this->ask('Do you want to publish swagger views');
        if (strpos(strtolower($publish), 'y') === 0)
        {
            $this->call($this->commands['publish-views'],array('package'=>'ralphowino/swagger'));
        }
    }

    protected function publishConfig() 
    {
        $publish = $this->ask('Do you want to publish swagger config');
        if (strpos(strtolower($publish), 'y') === 0)
        {
            $this->call($this->commands['publish-config'], array('package' => 'ralphowino/swagger'));
        }
    }

    protected function publishAssets() 
    {
        $publish = $this->ask('Do you want to publish swagger assets');
        if (strpos(strtolower($publish), 'y') === 0)
        {
            $this->call($this->commands['publish-assets'], array('package' => 'ralphowino/swagger'));
        }
    }

}
