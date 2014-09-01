#Warning

##This project is still in active development and the might be buggy. Use at your own discretion. The documentation might include functions that are still in development and so might not work as documentated. You can watch the project for an update once its stable

#Installation
##Via Composer

Edit `composer.json` and to require

    "ralphowino/swagger" : "dev-master"

##Add providers 

Edit `config/app.php` and  `"Ralphowino/Swagger/SwaggerServiceProvider"` in providers array

##Update config

In command line, run 

    php artisan config:publish ralphowino/swagger. 
    
This will allow you to run edit the configuration files based on your preference

##Publish templates
In command line, publish templates by running
    
    php artisan swagger:publish templates

##Publish assets
In command line, run 

    php artisan assets:publish ralphowino/swagger

#Getting Started

##Initialize your docs
To create a new documentation for your api, run:
    
    php artisan swagger:init

##Generate Docs from template
###Full Restful resource
You can document a restful resource simply by running:
    
    php artisan swagger:resource  pets --template=restful --fields="id:integer, name:string, description:string, photo:file, gender:enum,[male|female|unknown], vaccinated_at:datetime,nullable" --required="id, name" --response-fields="id, name, description, photo:string, vaccinated: bool, vaccinated_at, timestamps, softdeletes"

This will create a full restful stack with the methods: index, show, store, update, delete.

The fields parameter will be used for both input and output unless otherwise specified by the response-fields parameter


####Limit methods
You can also limit the methods to generate by passing an array of template methods
    
    php artisan swagger:resource pets --templates="restful.index, restful.show"

####Adding operations not in template
You can also add operations that are not specified in the template simply by running:

    
    php artisan swagger:operation restorePet

You will fill requested to specify a number of properties for the operation to complete its creation. You can also specify the various properties directly with the call as options. For instance:

    
    php artisan swagger:operation restorePet --method=PUT --route="pets/{id}/restore" --parameters="id:[type:integer,location:path,required:true]"

Then add this to the pet resource by running:

    
    php artisan swagger:resource pets --operations=restorePet

###Publishing your api docs
Once you have completed building your api docs, you can publish them for quicker rendering by swagger. Simply run:

    
    php artisan swagger:publish apis

## Node by Node generation
You can also generate a documentation by simply specifying one node at a time

###Types of documents
- **Api** - This is the final document that is rendered to swagger. It is a well structured swagger json document and is not parsed before rendering. To access api documents use:
       php artisan swagger:api
- **Resource** - This is a json document which can be parsed to generate a swagger api document. It contains all the details of a resource such as operations and models. To access resource documents use:
        php artisan swagger:resource
- **Model** - This is a representation of the resource entities. It contains the entity name and its properties. To access model documents use:
        php artisan swagger:model
- **Operation** - This is an action performed by the api. It represents the various end points of the api. To access operation documents use:
        php artisan swagger:operations

####New doc

####Update doc
####Delete doc
	
## Backup doc

