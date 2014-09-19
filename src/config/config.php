<?php 
return array(
    "api" => array(
        'version' => '1.0.0',
        "route" => url("api")
    ),

    "docs" => array(
        "route" => "docs",
        "start_url" => url("docs/index"),
        "path" => base_path()."/resources/docs",
        "info" => array(
            "title" => "API Documentation",
            "description" => "For more info on how to setup your swagger documentation check the github. Edit this message in the config files"
        ),
    )

);