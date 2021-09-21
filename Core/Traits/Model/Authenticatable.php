<?php

namespace Zed\Framework\Traits\Model;

use Zed\Framework\Token;

/**
 * @author @SMhdHsn
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
