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
        $data = (new UserFetchingService)->login($this->validateLoginRequest($request));

        return $this->response(
            Response::SUCCESS,
            $data,
            Response::HTTP_OK
        );
    }

    /**
     * Validating Login Action's Request Parameters.
     * 
     * @since 1.0.0
     * 
     * @param Request $request
     * 
     * @return object
     */
    private function validateLoginRequest(Request $request): object
    {
        return $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
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
        $data = (new UserCreatingService)->register($this->validateRegisterRequest($request));

        return $this->response(
            Response::SUCCESS,
            $data,
            Response::HTTP_OK
        );
    }

    /**
     * Validating Register Action's Request Parameters.
     * 
     * @since 1.0.0
     * 
     * @param Request $request
     * 
     * @return object
     */
    private function validateRegisterRequest(Request $request): object
    {
        return $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|numeric|max:11',
        ]);
    }
}
