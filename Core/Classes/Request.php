<?php

namespace Core\Classes;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class Request extends Validation
{
    /**
     * Given Parameters.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    protected array $params;

    /**
     * Creates an Instance Of This Class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->setRequestedParams($this->params);
    }

    /**
     * Setting Given Array's Items As Request Properties.
     * 
     * @since 1.0.0
     * 
     * @param array $params
     * 
     * @return void
     */
    protected function setRequestedParams(array $params): void
    {
        foreach ($params as $key => $chunk) {
            $this->$key = filter_input(
                $_SERVER['REQUEST_METHOD'] === 'GET' ? INPUT_GET : INPUT_POST, 
                $key, 
                FILTER_SANITIZE_SPECIAL_CHARS
            );
        }
    }
}
