<<<<<<< HEAD
<?php namespace Ralphowino\Swagger;

use Ralphowino\Swagger\Generators\SwaggerApi;
use Ralphowino\Swagger\Generators\SwaggerModel;
use Ralphowino\Swagger\Generators\SwaggerOperation;
=======
<?php

namespace Ralphowino\Swagger;
>>>>>>> 3ce400a786303ad2458bcc4c64fdda09cec523d0
use Ralphowino\Swagger\Templates\RestfulOperations;

class Swagger
{
    function __construct()
    {
        return $this;
    }

    function model($id)
    {
        return new SwaggerModel($id);
    }

    function api($path)
    {
        return new SwaggerApi($path);
    }

    function operation($nickname)
    {
        return new SwaggerOperation($nickname);
    }

    function generateEntities($entities)
    {
        foreach($entities as $entity)
        {
<<<<<<< HEAD
            $this->generateEntity($entity);
=======
            $temp = new RestfulOperations($entity);
            $temp->generate();
            $this->api('index')->apis([['path'=>\Str::plural($entity)]]);
>>>>>>> 3ce400a786303ad2458bcc4c64fdda09cec523d0
        }
    }

    function get($id)
    {
<<<<<<< HEAD
        $filepath = storage_path() . '/swagger/apis/' . strtolower($id) . '.json';
        if(!file_exists($filepath))
            $this->generateEntity($id);
        $api = json_decode(file_get_contents($filepath), true);
=======
        $api = json_decode(file_get_contents(storage_path() . '/swagger/apis/' . strtolower($id) . '.json'), true);
>>>>>>> 3ce400a786303ad2458bcc4c64fdda09cec523d0
        if (isset($api['operations'])) {
            foreach ($api['operations'] as $operation)
            {
                $operation = json_decode(file_get_contents(storage_path() . '/swagger/operations/' . $operation . '.json'), true);
                $path = $operation['path'];
                unset($operation['path']);
                $api['apis'][] = ['path' => $path, 'operations' => [$operation] ];
            }
            unset($api['operations']);
        }
        return json_encode($api);
    }

<<<<<<< HEAD
    /**
     * @param $entity
     */
    protected function generateEntity($entity)
    {
        $temp = new RestfulOperations($entity);
        $temp->generate();
        $this->api('index')->apis([['path' => \Str::plural($entity)]]);
    }

=======
>>>>>>> 3ce400a786303ad2458bcc4c64fdda09cec523d0
} 