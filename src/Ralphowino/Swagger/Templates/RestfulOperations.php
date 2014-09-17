<?php

namespace Ralphowino\Swagger\Templates;

use Str;
use Ralphowino\Swagger\Swagger;

class RestfulOperations extends Swagger
{

    function __construct($resource, Array $param = array())
    {
        $this->resource = $resource;
        $this->resource_plural = isset($param['plural']) ?$param['plural']: strtolower(Str::plural($resource));
        $this->resource_path = isset($param['path']) ?$param['path']: $this->resource_plural;
        $this->basepath = isset($param['path']) ?$param['path']: url('api/v1').'/';
        $this->responses = $this->setResponses(isset($param['responses'])? $param['responses'] : []);
        $this->auth = isset($param['auth']) ?$param['auth']: $this->resource_plural;
        $this->parameters = isset($param['param']) ?$param['param']: $this->resource_plural;
        $this->methods = isset($param['methods']) ?$param['methods']: ['index','show','store','update','delete'];
    }

    private function setResponses($responses)
    {
        return $responses;
    }

    function generateIndex()
    {
        return $this->operation('get' . ucfirst($this->resource_plural))
            ->method('GET')
            ->path($this->resource_path)
            ->parameters($this->getParam('index'))
            ->authorizations($this->getAuth('index'))
            ->notes("Get all " . ucfirst($this->resource_plural) . " paginated and sorted by criteria")
            ->summary("Get all " . ucfirst($this->resource_plural))
            ->responseMessages($this->getResponses('index'))
            ->getName();
    }

    function generateShow()
    {
        return $this->operation('get' . ucfirst($this->resource))
            ->method('GET')
            ->path($this->resource_path.'/{id}')
            ->parameters($this->getParam('show'))
            ->authorizations($this->getAuth('show'))
            ->notes("Get " . ucfirst($this->resource) . " using the ID provided")
            ->summary("Get " . ucfirst($this->resource)." by ID")
            ->responseMessages($this->getResponses('show'))
            ->getName();
    }

    function generateStore()
    {
        return $this->operation('create' . ucfirst($this->resource))
            ->method('POST')
            ->path($this->resource_path)
            ->parameters($this->getParam('create'))
            ->authorizations($this->getAuth('create'))
            ->notes("Create new " .$this->resource)
            ->summary("Create a new " .$this->resource)
            ->responseMessages($this->getResponses('create'))
            ->getName();
    }
    
    function generateUpdate()
    {
        return $this->operation('update' . ucfirst($this->resource))
            ->method('PUT')
            ->path($this->resource_path.'/{id}')
            ->parameters($this->getParam('update'))
            ->authorizations($this->getAuth('update'))
            ->notes("Update " .$this->resource." using provided id and ETag")
            ->summary("Update " .$this->resource)
            ->responseMessages($this->getResponses('update'))
            ->getName();
    }

    function generateDelete()
    {
        return $this->operation('delete' . ucfirst($this->resource))
            ->method('DELETE')
            ->path($this->resource_path.'/{id}')
            ->parameters($this->getParam('delete'))
            ->authorizations($this->getAuth('delete'))
            ->notes("Delete " . ucfirst($this->resource) . " using the ID provided")
            ->summary("Delete " . ucfirst($this->resource)." by ID")
            ->responseMessages($this->getResponses('delete'))
            ->getName();
    }


    function generate()
    {
        $this->api($this->resource_plural)->basePath($this->basepath);
        foreach($this->methods as $method)
        {
            $func = 'generate'.ucfirst($method);
            $this->api($this->resource_plural)->operations([$this->$func()]);
        }

    }

    private function getAuth($method)
    {
        $auth = [];

        return $auth;
    }

    private function getParam($method)
    {
        $func = 'get'.ucfirst($method).'Parameters';
        $param =  $this->$func();
        return $param;
    }

    function getIndexParameters()
    {
        return [
            [
                'name'=>'sortby',
                'description' => 'Sort '.$this->resource_plural.' by criteria. Default: alphabetical',
                'type' => 'string',
                'paramType' => 'query',
                'allowMultiple' => false,
                'enum' => ["popularity","recency","alphabetical"],
            ]
            ,
            [
                'name' => 'If-None-Match',
                'description' => 'ETag of the '.$this->resource_plural.' to check if there has been an update',
                'type' => 'string',
                'required' => false,
                'paramType' => 'header'
            ]
        ];
    }

    function getCreateParameters()
    {
        return [
            [
                'name'=>'body',
                'description' => 'Enter details for the new '.$this->resource,
                'type' => ucfirst($this->resource),
                'paramType' => 'body',
            ]
        ];
    }

    function getUpdateParameters()
    {
        return [
            [
                'name' => 'id',
                'description' => 'Id of the '.$this->resource.' to be updated',
                'type' => 'integer',
                'required' => true,
                'paramType' => 'path',
            ],
            [
                'name' => 'If-Match',
                'description' => 'ETag of the '.$this->resource.' to be updated. Ensures no concurrency conflicts occur',
                'type' => 'string',
                'required' => true,
                'paramType' => 'header'
            ],
            [
                'name'=>'body',
                'description' => 'Enter details for the new '.$this->resource.'. See model schema for format',
                'type' => ucfirst($this->resource),
                'paramType' => 'body',
            ]
        ];
    }

    function getShowParameters()
    {
        return [
            [
                'name' => 'id',
                'description' => 'Id of the '.$this->resource.' to be updated',
                'type' => 'integer',
                'required' => true,
                'paramType' => 'path',
            ],
            [
                'name' => 'If-None-Match',
                'description' => 'ETag of the '.$this->resource.' to check if it has been updated',
                'type' => 'string',
                'required' => false,
                'paramType' => 'header'
            ]
        ];
    }

    function getDeleteParameters()
    {
        return [
            [
                'name' => 'id',
                'description' => 'Id of the '.$this->resource.' to be updated',
                'type' => 'integer',
                'required' => true,
                'paramType' => 'path',
            ]
        ];
    }

    private function getResponses($method)
    {
        return $this->responses;
    }
} 