<?php 
return array(

    "swagger" => array(
        "version" => "1.2",

        "data-types" => array(
            "integer" => array("integer", "format" => "int32"),
            "long" => array("integer", "format" => "int64"),
            "float" => array("number", "format" => "float"),
            "double" => array("number", "format" => "double"),
            "string" => "string",
            "byte" => array("string", "format" => "byte"),
            "boolean" => "boolean",
            "date" => array("string", "format" => "date"),
            "dateTime" => array("string", "format" => "date-time"),
        ),

        "parameters" => array(
            "locations" => array(
                "default" => "query",
                "options" => array(
                    "path",
                    "query",
                    "header",
                    "form",
                    "body",
                )
            )
        )
    ),
    "api" => array(
        'version' => '1.0.0',
        "route" => url("api")
    ),

    "docs" => array(
        "route" => "docs",
        "start_url" => url("docs/index"),
        "path" => base_path()."/docs",
        "info" => array(
            "title" => "API Documentation",
            "description" => "For more info on how to setup your swagger documentation check the github. Edit this message in the config files"
        ),
    )

);