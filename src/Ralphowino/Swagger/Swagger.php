<?php namespace Ralphowino\Swagger;

use Illuminate\Support\Facades\Session;
use Ralphowino\Swagger\Generators\SwaggerApi;
use Ralphowino\Swagger\Generators\SwaggerResource;
use Ralphowino\Swagger\Generators\SwaggerModel;
use Ralphowino\Swagger\Generators\SwaggerOperation;
use Ralphowino\Swagger\Templates\RestfulOperations;

class Swagger
{
    function __construct()
    {
        return $this;
    }

    function api($path)
    {
        return new SwaggerApi($path);
    }

    function model($id)
    {
        return new SwaggerModel($id);
    }

    function resource($path)
    {
        return new SwaggerResource($path);
    }

    function operation($nickname)
    {
        return new SwaggerOperation($nickname);
    }

    function generateEntities($entities)
    {
        foreach($entities as $entity)
        {
            $this->generateEntity($entity);
        }
    }

    static function config($key)
    {
        $config = \Config::get('swagger::swagger');
        return array_get($config, $key);
    }

    function get($id)
    {
        $filepath = storage_path() . '/swagger/apis/' . strtolower($id) . '.json';
        if(file_exists($filepath))
        {
            return file_get_contents($filepath);
        }
        $filepath = storage_path() . '/swagger/resources/' . strtolower($id) . '.json';
        if(!file_exists($filepath))
        {
            if($id == 'index')
                Session::flash('swagger.error','Please update the configuration file and initialize swagger to start using it.');
            else
                Session::flash('swagger.error', 'Entity '.$id.' not found');
            return false;
        }
        $api = json_decode(file_get_contents($filepath), true);
        if (isset($api['operations'])) {
            if(is_string($api['operations'])) $api['operations'] = explode(',',$api['operations']);
            foreach ($api['operations'] as $operation)
            {
                $operation = json_decode(file_get_contents(storage_path() . '/swagger/operations/' . $operation . '.json'), true);
                $path = $operation['path'];
                unset($operation['path']);
                $api['apis'][] = ['path' => $path, 'operations' => [$operation]];
                $api['attachmodels'][] = $operation['type'];
            }
            unset($api['operations']);
        }
        if(isset($api['attachmodels']))
        {
            foreach ($api['attachmodels'] as $key)
            {
                $model = storage_path() . '/swagger/models/' . strtolower($key) . '.json';
                if(is_readable($model))
                    $api['models'][$key] = json_decode(file_get_contents($model), true);
            }
            unset($api['attachmodels']);
        }

        return json_encode($api);
    }

    /**
     * @param $entity
     */
    protected function generateEntity($entity)
    {
        $temp = new RestfulOperations($entity);
        $temp->generate();
        $this->api('index')->apis([['path' => \Str::plural($entity)]]);
    }

} 