<?php namespace Ralphowino\Swagger\Commands;


use Config;
use Ralphowino\Swagger\Commands\Traits\ModelGenerator;
use Ralphowino\Swagger\Commands\Traits\OperationGenerator;
use Ralphowino\Swagger\Commands\Traits\ResourceGenerator;

class SwaggerGenerate extends BaseCommand {

    use ModelGenerator, OperationGenerator, ResourceGenerator;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'swagger:generate';

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
        $this->swg = new \Ralphowino\Swagger\Swagger();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $type = $this->argument('type');
        $type = ucfirst($type);
        while(!in_array($type, ['Resource', 'Operation', 'Model']))
        {
            $type = $this->ask('Type of object to generate [Resource|Operation|Model] ?', 'resource');
            $type = ucfirst($type);
        };

        $name = $this->argument('name');
        while (is_null($name))
        {
            $name = $this->ask('Name of '.$type.'?');
        };
        $name = \Str::slug($name,'_');
        $generator = 'generate'.$type;
        $this->$generator($name);

        $this->info($type.':'.ucfirst($name).' Successfully Generated');
	}
}
