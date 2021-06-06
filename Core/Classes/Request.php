<?php

namespace Core\Classes;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class Request
{
    /**
     * Creates an Instance Of This Class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct(array $request)
    {
        $this->setAttributes($request);
    }

    /**
     * Setting Given Array's Items As Request Properties.
     * 
     * @since 1.0.0
     * 
     * @param array $request
     * 
     * @return void
     */
    private function setAttributes(array $request): void
    {
        foreach ($request as $key => $chunk) {
            $this->$key = $chunk;
        }
    }
}
