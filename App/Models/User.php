<?php

namespace App\Models;

use Core\Traits\Model\Authenticatable;
use Core\Classes\BaseModel;

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
