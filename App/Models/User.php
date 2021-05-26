<?php

namespace App\Models;

use Core\Classes\BaseModel;
use Core\Traits\Authenticatable;

/**
 * @author @smhdhsn
 * 
 * @version 1.2.0
 */
class User extends BaseModel
{
    use Authenticatable;

    /**
     * Model's Table Name.
     * 
     * @since 1.1.0
     * 
     * @var string
     */
    protected $table = 'users';
}
