<p align="center">
  <img title="Brainsss...!" src="https://raw.githubusercontent.com/SMhdHsn/SMhdHsn/master/Assets/Images/zed_logo.jpeg">
</p>

## About
ZED is an API-Based Micro-Framework powered by PHP.
### Features
- ORM.
- Routing.
- Migration.
- Command.
- Request Validation.

## Getting started
Make sure you have `composer` installed in your machine and then create a new ZED project using composer:
```shell
composer create-project smhdhsn/zed ProjectName
```
After the application has been created, you may start ZED's local development server using command line:
```shell
php command serve
```
You can provide a custom port to serve on like the following:
```shell
php command serve --port=8080
```
## Documentation

### Routing

#### Defining routes
You can choose between three options for defining a route for your application.

#### Via closure
```php
$router->get('/projects', function () {
    return 'Hello, World !';
});
```
#### Via string
```php
$router->get('/projects', 'ProjectController@index');
```
#### Via array
```php
use App\Controllers\ProjectController;

$router->get('/projects', [ProjectController::class, 'index']);
```
### Middleware
You can implement a middleware to a route like the following.
```php
$router->get('/project/:projectId', 'ProjectController@show', [
    'checkAvailability'
]);
```
> :information_source: You need to list the method name that is responsible for your middleware inside the array.
### Protecting routes
As I mentioned before, you can provide middleware within an array as the third parameter to the route.
```php
$router->get('/project/:projectId', 'ProjectController@show', [
    'auth'
]);
```
The middleware auth is responsible for protecting routes from unauthenticated requests. This middleware is powered by JWT, you may check out Token class under path `Core/Classes/Token` for more information about how the middleware works.

### Route params
You may wish to pass your route parameters to your application. You may do so like the following.
```php
$router->get('/projects/:projectId/logs/:logId', 'ProjectController@index');
```
> :information_source: In your controller or closure you'll receive Request object as your first parameter.
```php
<?php

namespace App\Controllers;

use Zed\Framework\{Controller, Request};

class ProjectController extends Controller
{
    /**
    * Showing project's index page.
    *
    * @param Request $request
    * @param int $projectId
    * @param int $logId
    *
    * @return string
    */
    public function index(Request $request, int $projectId, int $logId): string
    {
        //
    }
}
```
### Request
Request object contains every parameter passed to the application, whether it's from request body or query string, you can access request params like following:
```php
$request->projectName;
```
### Request validation
You can validate your request and in case of any errors show a proper error message.
```php
$request->validate([
    'name' => 'required|string|min:10',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|string|max:64',
]);
```
#### Available validation rules

##### Required
The field under this rule is required and must be provided to the application.
```php
$request->validate([
    'name' => 'required',
]);
```
##### String
The field under this rule must be a valid string.
```php
$request->validate([
    'surname' => 'string',
]);
```
##### Numeric
The field under this rule must be a valid numeric string.
```php
$request->validate([
    'age' => 'numeric',
]);
```
##### Email
The field under this rule must be a valid email.
```php
$request->validate([
    'email' => 'email',
]);
```
##### Maximum
The field under this rule must contain less characters than given value.
```php
$request->validate([
    'password' => 'max:64',
]);
```
##### Minimum
The field under this rule must contain more characters than given value.
```php
$request->validate([
    'name' => 'min:5',
]);
```
##### Unique
The field under this rule must be unique in the database, you have to provide the column you wish to check for uniqueness of the request attribute after table name.
```php
$request->validate([
    'email' => 'unique:users,email',
]);
```
In this case, application will look through users table on database and checks if column email exists with the same value or not.

### Response
The only available response type is JSON, for the sake of consistency of response properties you may use Controller's response() method. This method accepts 3 parameters: Response word, Response data, Response HTTP-code.
```php
<?php

namespace App\Controllers;

use Zed\Framework\{Controller, Request, Response};

class ProjectController extends Controller
{
    /**
    * Showing project's index page.
    *
    * @param Request $request
    * @param int $projectId
    * @param int $logId
    *
    * @return string
    */
    public function index(Request $request, int $projectId, int $logId): string
    {
        $data = "{$projectId} - {$logId}";

        return $this->response(
            Response::SUCCESS,
            $data,
            Response::HTTP_OK
        );
    }
}
```
You may want to check out Response class, there's plenty of response words and codes there that you can use.

#### Error
In case of possible errors you can also use Controller's error() method:
```php
<?php

namespace App\Controllers;

use Zed\Framework\{Controller, Request, Response};
use Exception;

class ProjectController extends Controller
{
    /**
    * Showing project's index page.
    *
    * @param Request $request
    * @param int $projectId
    * @param int $logId
    *
    * @return string
    */
    public function index(Request $request, int $projectId, int $logId): string
    {
        $data = "{$projectId} - {$logId}";

        try {
            return $this->response(
                Response::SUCCESS,
                $data,
                Response::HTTP_OK
            );
        } catch (Exception $exception) {
            return $this->error(
                Response::ERROR,
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
```
### ORM
ZED Provides some functionalities to interact with the database and perform simple CRUD operations.

#### Creating
```php
Project::create([
    'author' => $request->author,
    'name' => $request->name,
    'type' => $request->type
]);
```
#### Finding
You have 2 choices, whether you can find a record with where clause or you can find the record by their unique id.

##### Where clause
Returns a collection of objects, returns an empty collection if there's no matching record.
```php
Project::where('name', $request->name)->get();
```
##### Find method
Returns an object of type model, throws a `NotFoundException` if there's no matching record.
```php
Project::find($id);
```
#### Updating
```php
$project = Project::find($id);

$project->update([
    'name' => $request->name,
    'type' => $request->type
]);
```
#### Deleting
```php
$project = Project::find($id);

$project->delete();
```
### Command
ZED also provides a way to interact with the application via the command line. You can create your own command with the command below:
```shell
php command make:command YourCommand
```
This command will create your command in path `App/Commands`.

After creating the command you need to address it to the application inside `Routes/command` file like the following:
```php
$command->define('command-name', \App\Command\YourCommand::class);
```
You can also provide a closure as the second parameter to the define method to handle your command's action:
```php
$command->modify('command-name', function () {
    //
});
```
> :information_source: Every parameter after the command name can be accessed within the command's class or closure.
```shell
php command say 'Hello World !'
```
Inside command.php file:
```php
use Zed\Framework\CommandLineInterface as CLI;

$command->modify('say', function (string $message = 'Hello') {
    return CLI::out($message);
});
```
Also, the class CommandLineInterface includes massive command-line options for you to take advantage of like cli color, background, font, etc... You may wish to check it out at the path `Core/CommandLineInterface`

#### Predefined commands

##### Migrate
This command handles migration operations

Running migrations:
```shell
php command migrate
```
Rolling back migration:
```shell
php command migrate:rollback
```
Resetting all migrations:
```shell
php command migrate:reset
```
Resetting and then running all migrations again:
```shell
php command migrate:fresh
```
##### Make
This command is responsible for creating classes within the application to save time.

Creating a new controller:
```shell
php command make:controller UserController
```
Creating a new model:
```shell
php command make:model User
```
Creating a new repository:
```shell
php command make:repository UserRepository
```
Creating a new service:
```shell
php command make:service UserCreatingService
```
Creating new migration:
```shell
php command make:migration create_users_table
```
Creating new command:  
```shell
php command make:command UserCreatingCommand
```
## License
The ZED micro-framework is open-sourced software licensed under the [MIT license](LICENSE).
