<?php namespace Ralphowino\Swagger\Commands\Traits;

trait OperationGenerator
{
    function generateOperation($name)
    {

        $operation = $this->swg->operation(camel_case($name));
        $this->addOperationProperties($operation);
    }

    function addOperationProperties($operation)
    {
        //method
        $method = $this->ask("Operation http verb:");
        // Todo: Check if valid
        $operation->method($method);
        //path
        $path = $this->ask("Operation relative path:");
        $operation->path('/'.$path);
        //type
        $type = $this->ask("Operation response model:");
        // Todo: check if exists, create or enter another
        $operation->type($type);
        //summary
        $summary = $this->ask("Operation summary:");
        $operation->summary($summary);
        //notes
        $notes = $this->ask("Operation notes:",$summary);
        $operation->notes($notes);
        //parameters
        $this->addOperationParameters($operation);
        //responses
    }

    function addOperationParameters($operation)
    {
        $name = $this->ask('Enter name of Operation Parameter [Press enter to quit, h for help]:');
        if (is_null($name)) return;
        if ($name == 'h') 
        {
            //Todo: retrieve from config
            $this->info("Parameter locations: query [default], path, header, form, body");
            $this->addOperationParameters($operation);
        }
        $param['name'] = $name;
        $param['description'] = strtolower($this->ask('Describe the parameter:'));
        $param['paramType'] = strtolower($this->ask('Enter location of parameter:', 'query'));
        //To do : check if type is valid
        $param['type'] = strtolower($this->ask('Enter type of the parameter value:', 'string'));
        $param['required'] = in_array(strtolower($this->ask('Is the parameter required [y/n]:', 'n')),array('y','yes'))?true:false;
        $param['allowMultiple'] = in_array(strtolower($this->ask('Allow multiple versions [y/n]:', 'n')),array('y','yes'))?true:false;
        $operation->parameters(array($param));
        $this->info('Added parameter');
        $this->addOperationParameters($operation);
    }
} 