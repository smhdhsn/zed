<?php

namespace App\Controllers;

use Core\Classes\{BaseController, Response};
use App\Services\User\{UserFetchingService, UserCreatingService};

/**
 * @author @smhdhsn
 * 
 * @version 1.2.0
 */
class UserController extends BaseController
{
    /**
     * Logging In The User.
     * 
     * @since 1.2.0
     * 
     * @param array $request
     * 
     * @return string
     */
    public function login(array $request): string
    {
        $data = (new UserFetchingService)->login($request);

        return $this->response(
            Response::SUCCESS,
            $data,
            Response::HTTP_OK
        );
    }

    /**
     * Registering User.
     * 
     * @since 1.1.0
     * 
     * @param array $request
     * 
     * @return string
     */
    public function register(array $request): string
    {
        $data = (new UserCreatingService)->register($request);

        return $this->response(
            Response::SUCCESS,
            $data,
            Response::HTTP_OK
        );
    }
}
