<?php  namespace Ralphowino\Swagger\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;


class BaseCommand extends Command
{

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('type', InputArgument::OPTIONAL, 'Type of the object to generate'),
            array('name', InputArgument::OPTIONAL, 'Name of the object to generate'),
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