<?php

namespace App\Controllers;

use Core\Classes\{Controller, Response};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class WelcomeController extends Controller
{
    /**
     * Home page.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function index(): string
    {
        return $this->response(
            Response::SUCCESS,
            'Welcome to ZED framework.',
            Response::HTTP_OK
        );
    }
}
