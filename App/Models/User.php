<?php

namespace App\Models;

use Core\Classes\BaseModel;
use Core\Traits\Authenticatable;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class User extends BaseModel
{
    use Authenticatable;

    /**
     * Model's Table Name.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    protected $table = 'users';
}
