<?php

namespace Core\Traits\Model;

use Core\Classes\Token;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Authenticatable
{
    /**
     * Logging User In.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function login(): string
    {
        return (new Token)->generate($this);
    }
}
