#Installation
##Via Composer

Edit `composer.json` and to require

    "ralphowino/swagger" : "dev-master"

##Add providers 

Edit `config/app.php` and  `"Ralphowino/Swagger/SwaggerServiceProvider"` in providers array

#Getting Started

##Initialize your docs
To create a new documentation for your api, run:
    
    php artisan swagger:init

##Generate Docs from CLI

There are 4 doc types: api, resource, model, operation

###Api

This doc type allows you to create a standard swagger resource doc type.

To generate one, use command:

    php artisan swagger:generate api apiname
    
###Resource

This doc type is a summarised version of the standard swagger resource and includes 2 variables: models and operations.

To generate one, use command:

    php artisan swagger:generate resource resourcename
    
*You will be requested to specify a list of operations to include*

###Operation

This doc type represents a single action/route in your api. To generate one, use command:

    php artisan swagger:generate operation operationName
    
*You will be requested to specify different details about the action such as Verb, Route, etc*

###Model

This doc type represents a model/custom datatype used in your api. To generate one use command:

    php artisan swagger:generate model Modelname
    
*You will be asked properties of the model and the required ones*


##Quick Tutorial

We can create a quick documentation for a to-do list api with simple CRUD function for todo items.

###Initialize
    
    php artisan swagger:init
    
*Make sure you have updated your api domain name in config/app.php*

###Create Models

    php artisan swagger:generate model Todo --properties="id:integer, title:string, notes:text, completed:boolean, created_at:datetime, updated_at:datetime, completed_at:datetime, deleted_at:datetime" --required="id,title"


    php artisan swagger:generate model Item --properties="title:string, notes:text, completed:boolean" --required="title"
    
###Create Operations

**1. Create Todo**

    php artisan swagger:generate operation createTodo
    
*General details*

    verb: POST
    path: todos
    model: Todo
    summary: Create a new todo item
    notes: Create a new todo item
    
*Parameter: id

    parameter: body
    parameter.description: create a new todo item
    parameter.location: body
    parameter.type: iTodo
    parameter.required: n
    parameter.multiple: n
    
    
    
**2.Get Todo**

    php artisan swagger:generate operation getTodo

To populate the operation enter the following answers:

*General details*

    verb: GET
    path: todos/{id}
    model: Todo
    summary: Get todo item using its id
    notes: Get a todo item using its id. Define fields to retrieve or none if not changed

*Parameter: id*

    parameter: id
    parameter.description: id of todo item to retrieve
    parameter.location: path
    parameter.type: integer
    parameter.required: y
    parameter.multiple: n
    
*Parameter: if-match-none*

    parameter: if-match-none
    parameter.description: return if etag doesn't match
    parameter.location: header
    parameter.type: string
    parameter.required: n
    parameter.multiple: n
    
    
*Parameter: fields*

    parameter: fields
    parameter.description: fields to return (limited to fields available)
    parameter.location: query
    parameter.type: string
    parameter.required: n
    parameter.multiple: n

**3.Get Todos**

    php artisan swagger:generate operation getTodos

To populate the operation enter the following answers:

*General details*

    verb: GET
    path: todo
    model: array
    type: Todo
    summary: Get todo items
    notes: Get a todo items paginated and filtered based on parameters

*Parameter: if-match-none*

    parameter: if-match-none
    parameter.description: return if etag doesn't match
    parameter.location: header
    parameter.type: string
    parameter.required: n
    parameter.multiple: n
    
*Parameter: id*

    parameter: id
    parameter.description: filter by ids. Comma separated list allowed
    parameter.location: query
    parameter.type: string
    parameter.required: n
    parameter.multiple: n
    
    
*Parameter: fields*

    parameter: fields
    parameter.description: fields to return (limited to fields available)
    parameter.location: query
    parameter.type: string
    parameter.required: n
    parameter.multiple: n
    
    
*Parameter: page*

    parameter: page
    parameter.description: page to display
    parameter.location: query
    parameter.type: string
    parameter.required: n
    parameter.multiple: n


*Parameter: per_page*

    parameter: per_page
    parameter.description: items to display per page
    parameter.location: query
    parameter.type: string
    parameter.required: n
    parameter.multiple: n


**4.Update Todos**

    php artisan swagger:generate operation updateTodo
    
*General details*

    verb: PUT
    path: todos/{id}
    model: Todo
    summary: Update a todo item based on ID
    notes:
    
*Parameter: body*

    parameter: body
    parameter.description: updated fields
    parameter.location: body
    parameter.type: iTodo
    parameter.required: y
    parameter.multiple: n


**5.Delete Todo**

    php artisan swagger:generate operation deleteTodo
    
*General details*
    verb: DELETE
    path: todos/{id}
    model: Todo
    summary: Delete a todo item based on ID
    notes:
