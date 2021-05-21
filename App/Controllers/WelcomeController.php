<?php

namespace App\Controllers;

use Core\Response;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class WelcomeController extends BaseController
{
    /**
     * Main Index Method.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function index(): string
    {
        return $this->response(
            Response::SUCCESS,
            'Welcome To php-mon Framework.',
            Response::HTTP_OK
        );
    }
}
