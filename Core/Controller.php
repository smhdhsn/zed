<?php

namespace Zed\Framework;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class Controller extends Response
{
    /**
     * Successful response.
     *
     * @since 1.0.0
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
     * Unsuccessful response.
     *
     * @since 1.0.0
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
}
