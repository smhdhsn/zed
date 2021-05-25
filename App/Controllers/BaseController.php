<?php

namespace App\Controllers;

use Core\Classes\Response;

/**
 * @author @smhdhsn
 * 
 * @version 1.1.0
 */
class BaseController extends Response
{
    /**
     * Styling Response For Successful Responses.
     *
     * @since 1.1.0
     *
     * @param string $status
     * @param mixed $data
     * @param int $code
     *
     * @return string
     */
    public function response(string $status, $data, int $code): string
    {
        http_response_code($code);

    	return json_encode([
    		'status' => $status,
    		'data' => $data,
    		'code' => $code,
    	]);
    }

    /**
     * Styling Response For Unsuccessful Responses.
     *
     * @since 1.1.0
     *
     * @param string $status
     * @param mixed $data
     * @param int $code
     *
     * @return string
     */
    public function error(string $status, $data, int $code): string
    {
        http_response_code($code);

    	return json_encode([
    		'status' => $status,
    		'data' => $data,
    		'code' => $code,
    	]);
    }

    /**
     * Generating Not Found Response.
     * 
     * @since 1.2.1
     * 
     * @return string
     */
    public function notFound(): string
    {
        return (new BaseController)->error(
            Response::ERROR,
            'Invalid Route.',
            Response::HTTP_NOT_FOUND
        );
    }
}
