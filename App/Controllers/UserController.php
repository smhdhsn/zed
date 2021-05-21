<?php

namespace App\Controllers;

use Core\Response;
use App\Models\User;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class UserController extends BaseController
{
    /**
     * User's Instance.
     * 
     * @since 1.1.0
     * 
     * @var object
     */
    public $model;

    /**
     * Creates an Instance Of This Class.
     * 
     * @since 1.1.0
     * 
     * @return void
     */
    public function __construct()
    {
        $this->model = new User;
    }

    /**
     * Logging In The User.
     * 
     * @since 1.1.0
     * 
     * @param array $request
     * 
     * @return string
     */
    public function login(array $request): string
    {
        $data = $this->model->login($request);

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
        $data = $this->model->register($request);

        return $this->response(
            Response::SUCCESS,
            $data,
            Response::HTTP_OK
        );
    }
}
