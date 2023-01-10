# Lumen Backend Hospital

A Backend for Halotec Indonesia skill test.


### Installation

- Clone the Repo:comp
    - `gh repo clone rickysut/behospital`

- `cd behospital`
- `composer create-project`
- `php artisan key:generate`
- `php artisan jwt:secret`
- `php artisan migrate`



#### Add a new resource endpoint

- Add endpoint in `routes/web.php`.

    ```php
    $router->group(['middleware' => 'auth:api'], function ($router) {
        $app->get('/users', 'UserController@index');
    });
    ```

- Add controller with `php artisan make:controller {name}` command

- Add model at `php artisan make:model {name}`. You can use `-m` flag to add migration file and `-f` flag for factory file.

- Add service at `app` directory.

    ```php
    <?php

    namespace App;

    class Accounts
    {
        // Add service methods.
    }
    ```

- Load the service in controller.

    ```php
    <?php

    namespace App\Http\Controllers;

    use App\Accounts;

    class UserController extends Controller
    {
        /**
         * Controller constructor.
         *
         * @param  \App\Accounts  $accounts
         */
        public function __construct(Accounts $accounts)
        {
            $this->accounts = $accounts;
        }

        // Add controller methods.
    }
    ```

    You can also use Facade for the services.

- Add transformers at `app/Transformers` directory or use the command `php artisan make:transformer {name}`.

    ```php
    <?php

    namespace App\Transformers;

    use App\User;
    use League\Fractal\TransformerAbstract;

    class UserTransformer extends TransformerAbstract
    {
        /**
         * Transform object to array.
         *
         * @param  \App\User $user
         * @return array
         */
        public function transform(User $user): array
        {
            return [
                'id' => (int) $user->id,
                'email' => (string) $user->email,
            ];
        }
    }
    ```

- Render JSON in controllers

    ```php
    <?php

    namespace App\Http\Controllers;

    use App\Accounts;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;

    class UserController extends Controller
    {
        /**
         * Controller constructor.
         *
         * @param  \App\Accounts  $accounts
         */
        public function __construct(Accounts $accounts)
        {
            $this->accounts = $accounts;
        }

        /**
         * List of all users.
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function index(): JsonResponse
        {
            $users = $this->accounts->getUsersWithPagination($request);

            return response()->json($users, Response::HTTP_OK);
        }
    }
    ```

- Exception message, status code and details can be displayed by declaring these as methods in an exception class.

    ```php
    <?php

    namespace App\Exceptions;

    use Symfony\Component\HttpKernel\Exception\HttpException;

    class CustomException extends HttpException
    {
        public function getMessage(): string
        {
            return 'Custom message';
        }

        public function getStatusCode(): int
        {
            return 500;
        }

        public function getDetails(): ?array
        {
            return [];
        }
    }
    ```

#### Authentication

- Create Bearer Token

```
curl --request POST 'http://127.0.0.1:8000/auth' \
    --header 'Content-Type: application/json' \
    --data-raw '{
        "email": "admin@localtest.me",
        "password": "password"
    }'
```

Example Bearer Token -

```
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXV0aCIsImlhdCI6MTYzNDI2MTQzNSwiZXhwIjoxNjM0MjY1MDM1LCJuYmYiOjE2MzQyNjE0MzUsImp0aSI6IlVzVm1PZk52dTBrOTZFYk4iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.xjvzoFCkxlB_k2z0R0zkeatDDRU0hAbRFMETAEZBsss
```

Bearer Token need to passed in the request header as 

```
Authorization: Bearer <token>
```

- Get Current User

```
curl --request GET 'http://127.0.0.1:8000/auth' \
    --header 'Content-Type: application/json' \
    --header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXV0aCIsImlhdCI6MTYzNDI2MTQzNSwiZXhwIjoxNjM0MjY1MDM1LCJuYmYiOjE2MzQyNjE0MzUsImp0aSI6IlVzVm1PZk52dTBrOTZFYk4iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.xjvzoFCkxlB_k2z0R0zkeatDDRU0hAbRFMETAEZBsss'
```




