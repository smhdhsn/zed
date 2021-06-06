<?php

namespace App\Controllers;

use Core\Classes\{BaseController, Request, Response};
use App\Services\User\{UserFetchingService, UserCreatingService};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class UserController extends BaseController
{
    /**
     * Logging In The User.
     * 
     * @since 1.0.0
     * 
     * @param Request $request
     * 
     * @return string
     */
    public function login(Request $request): string
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
     * @since 1.0.0
     * 
     * @param Request $request
     * 
     * @return string
     */
    public function register(Request $request): string
    {
        $data = (new UserCreatingService)->register($request);

        return $this->response(
            Response::SUCCESS,
            $data,
            Response::HTTP_OK
        );
    }
}
