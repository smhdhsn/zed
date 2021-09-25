<?php

namespace App\Traits;

use Zed\Framework\Token;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
trait Authenticatable
{
    /**
     * login user.
     * 
     * @since 1.0.1
     * 
     * @return string
     */
    public function login(): string
    {
        return (new Token)->generate($this);
    }
}
