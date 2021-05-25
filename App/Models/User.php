<?php

namespace App\Models;

use Core\Classes\Token;

/**
 * @author @smhdhsn
 * 
 * @version 1.2.0
 */
class User extends BaseModel
{
    /**
     * Model's Table Name.
     * 
     * @since 1.1.0
     * 
     * @var string
     */
    protected $table = 'users';

    /**
     * Logging User In.
     * 
     * @since 1.2.0
     * 
     * @param array $user
     * 
     * @return string
     */
    public function login(array $user)
    {
        return (new Token)->generate($user);
    }
}
