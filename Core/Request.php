<?php

namespace Zed\Framework;

use Zed\Framework\Validation\ValidationInitiator;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class Request
{
    /**
     * Given parameters.
     * 
     * @since 1.0.1
     * 
     * @var null|array
     */
    private array $params = [];

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    public function __construct(array $params)
    {
        $this->setRequestedParams($params);
    }

    /**
     * Set each "params" variable's index as properties of request class.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    private function setRequestedParams(array $params): void
    {
        foreach ($params as $key => $chunk) {
            $this->$key = filter_input(
                $_SERVER['REQUEST_METHOD'] === 'GET' ? INPUT_GET : INPUT_POST, 
                $key, 
                FILTER_SANITIZE_SPECIAL_CHARS
            );

            $this->params[$key] = $chunk;
        }
    }

    /**
     * Get request input(s) as array of parameters.
     * 
     * @since 1.0.1
     * 
     * @return array
     */
    public function input(): array
    {
        return $this->params;
    }

    /**
     * Validate request input(s) with given rule(s).
     * 
     * @since 1.0.1
     * 
     * @param array $validationRules
     * 
     * @return Request
     */
    public function validate(array $validationRules): Request
    {
        (new ValidationInitiator($validationRules, $this->input()))
            ->initiate();

        return $this;
    }
}
