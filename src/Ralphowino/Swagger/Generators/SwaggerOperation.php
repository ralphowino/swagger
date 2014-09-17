<?php

namespace Ralphowino\Swagger\Generators;

use Illuminate\Support\Str;

class SwaggerOperation extends SwaggerBase
{
    function __construct($nickname)
    {
        $this->filename = storage_path().'/swagger/operations/'.Str::snake($nickname);
        $this->default= array('nickname'=>$nickname,'method'=>'GET');
        return parent::__construct();
    }

    function getName()
    {
        return str_replace('.json','',basename($this->filename));
    }
} 