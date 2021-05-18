<?php

namespace App\Controllers;

use Exception;
use Core\{BaseController, Response};

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
        try {
            return $this->response(
                Response::SUCCESS,
                'Welcome To php-mon Framework.',
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return $this->error(
                Response::ERROR,
                $e,
                method_exists($e, 'getStatusCode') ? $e->getStatusCode() : $e->getCode()
            );
        }
    }
}
