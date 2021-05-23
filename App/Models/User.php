<?php

namespace App\Models;

use PDO;
use Core\{Response, Token};
use App\Controllers\BaseController;

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
    public $table = 'users';

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
