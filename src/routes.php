<?php

Route::get(Config::get('swagger::path','docs'),function(){
    return View::make('swagger::index');
});

Route::get(Config::get('swagger::path', 'docs').'/{entity?}',function($entity = 'index')
{
    $swg = new Ralphowino\Swagger\Swagger();
    $doc = $swg->get($entity);
    if($doc)
        return Response::make($doc);
    return Response::json(array('swaggerVersion'=>'1.2','apis' => array(),'info' => array('title' => 'Swagger Error', 'description' => Session::get('swagger.error'))));
});