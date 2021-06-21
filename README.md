<p align="center">
  <img src="https://repository-images.githubusercontent.com/367858748/2dafa900-cf67-11eb-8ff5-e6f4882cef15" width="400">
</p>

## About
PHP-M is an API-based micro-framework powered by PHP.

## Serving application
You can serve the application with the following command, just head to the root of the project with the command line and type:

    php command serve
    
You can provide a custom port to serve on like the following:

    php command serve --port=8080
    
## Documentation

### Routing

#### Defining routes
You can choose between three options for defining a route for your application.

#### Via closure

    $route->get('/projects', function () {
      return 'Hello, World !';
    });
    
#### Via string

    $route->get('/projects', 'ProjectController@index');
    
#### Via array

    use App\Controllers\ProjectController;
    
    $route->get('/projects', [ProjectController::class, 'index']);
    
### Middleware
You can implement a middleware to a route like the following.

    $route->get('/project/:projectId', 'ProjectController@show', [
        'checkAvailability'
    ]);

Keep in mind that you need to provide method name that is responsible for your middleware.

### Protecting routes
As I mentioned before, you can provide middleware within an array as the third parameter to the route.

    $route->get('/project/:projectId', 'ProjectController@show', [
        'auth'
    ]);
    
The middleware auth is responsible for protecting routes from unauthenticated requests. This middleware is powered by JWT, you may check out Token class under path \Core\Classes\Token for more information about how the middleware works.

### Route params
You may wish to pass your route parameters to your application. You may do so like the following.

    $route->get('/projects/:projectId/logs/:logId', 'ProjectController@index');

Keep in mind that in your controller or closure you'll receive Request object as your first parameter:

    <?php

    namespace App\Controllers;

    use Core\Classes\{BaseController, Request};

    class ProjectController extends BaseController
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
    
### Request
Request object contains every parameter passed to the application, whether it's from request body or query string, you can access request params like following:

    $request->projectName;
    
### Request validation
You can validate your request and in case of any errors show a proper error message.

    $request->validate([
        'name' => ['required', 'string'],
        'age' => ['required', 'numeric', ['min' => 18]],
        'height' => ['required', 'numeric', ['max' => 190]],
        'email' => ['required', 'email', ['unique' => 'users']],
    ]);

#### Available validation rules

##### Required
The field under this rule is required and must be provided to the application.

##### String
The field under this rule must be a valid string.

##### Numeric
The field under this rule must be a valid numeric string.

##### Email
The field under this rule must be a valid email.

##### Maximum
The field under this rule must be less than the given value.

    $request->validate([
        'height' => ['required', 'numeric', ['max' => 190]],
    ]);

##### Minimum
The field under this rule must be more than the given value.

    $request->validate([
        'age' => ['required', 'numeric', ['min' => 18]],
    ]);
    
##### Unique
The field under this rule must be unique in the database.

    $request->validate([
        'email' => ['required', 'email', ['unique' => 'users']],
    ]);
    
In this case, application will look through users table on database and checks if column email exists with the same value or not.

### Response
The only available response type is JSON, for the sake of consistency of response properties you may use BaseController's response() method. This method accepts 3 parameters: Response word, Response data, Response HTTP-code.

    <?php

    namespace App\Controllers;

    use Core\Classes\{BaseController, Request, Response};

    class ProjectController extends BaseController
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
    
You may want to check out Response class, there's plenty of response words and codes there that you can use.

#### Error
In case of possible errors you can also use BaseController's error() method:

    <?php

    namespace App\Controllers;

    use Exception;
    use Core\Classes\{BaseController, Request, Response};

    class ProjectController extends BaseController
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
    
### ORM
PHP-M Provides some functionalities to interact with the database and perform simple CRUD operations.

#### Creating

    Project::create([
        'author' => $request->author,
        'name' => $request->name,
        'type' => $request->type
    ]);
    
#### Finding
You have 2 choices, whether you can find a record with where clause or you can find the record by their unique id.

##### Where clause

    Project::where([
        'name' => $request->name,
    ])->get();
    
##### Find method
    
    Project::find($id);
    
#### Updating

    $project = Project::find($id);

    $project->update([
        'name' => $request->name,
        'type' => $request->type
    ]);
    
#### Deleting

    $project = Project::find($id);
    
    $project->delete();
  
### Command
PHP-M also provides a way to interact with the application via the command line. You can create your own command with the command below:

    php command make:command YourCommand
    
This command will create your command in path \App\Commands.

After creating the command you need to address it to the application inside \Routes\command.php file like the following:

    $command->define('command-name', \App\Command\YourCommand::class);
    
You can also provide a closure as the second parameter to the define method to handle your command's action:

    $command->modify('command-name', function () {
        //
    });

Keep in mind that every parameter after the command name can be accessed within the command's class or closure:

    php command say 'Hello World !'

    use Core\Classes\CommandLineInterface as CLI;

    $command->modify('say', function (string $message = 'Hello') {
        return CLI::out($message);
    });
    
Also, the class CommandLineInterface includes massive command-line options for you to take advantage of like cli color, background, font, etc... You may wish to check it out at the path \Core\Classes\CommandLineInterface

#### Available commands

##### Migrate
This command handles migration operations

For running migrations:

    php command migrate
    
For rolling back migration:

    php command migrate:rollback
    
For resetting all migrations:

    php command migrate:reset
    
For resetting and then running all migrations again:

    php command migrate:fresh
    
##### Make
This command is responsible for creating classes within the application to save time.

For creating a new controller:

    php command make:controller UserController
    
For creating a new model:

    php command make:model User
    
For creating a new repository:

    php command make:repository UserRepository
    
For creating a new service:

    php command make:service UserCreatingService
    
For creating new migration:

    php command make:migration create_users_table
    
For creating new command:

    php command make:command UserCreatindCommand
    
## License
The PHP-M micro-framework is open-sourced software licensed under the [MIT license](LICENSE).
