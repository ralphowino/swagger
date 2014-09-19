<?php
return array(
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
        "datetime" => array("string", "format" => "date-time"),
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
);