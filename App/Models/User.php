<?php

namespace App\Models;

use Core\Traits\Model\Authenticatable;
use Core\Classes\Model;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class User extends Model
{
    use Authenticatable;

    /**
     * Model's table name.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    protected $table = 'users';
}
