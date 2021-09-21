<?php

namespace Zed\Framework;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class Request extends Validation
{
    /**
     * Given parameters.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    protected array $params;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct(array $params)
    {
        parent::__construct();

        $this->params = $params;
        $this->setRequestedParams($this->params);
    }

    /**
     * Set given array's items as properties of request class.
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
