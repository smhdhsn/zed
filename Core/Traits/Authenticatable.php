<?php

namespace Core\Traits;

use Core\Classes\Token;

/**
 * @author @smhdhsn
 * 
 * @version 1.2.1
 */
trait Authenticatable
{
    /**
     * Logging User In.
     * 
     * @since 1.2.0
     * 
     * @return string
     */
    public function login()
    {
        return (new Token)->generate($this);
    }
}
