<?php

namespace App\Controllers;

use App\Services\User\{UserFetchingService, UserCreatingService};
use Zed\Framework\{Controller, Request, Response};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class UserController extends Controller
{
    /**
     * User login.
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
     * Validate login parameters.
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
     * Register user.
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
     * Validate register parameters.
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
