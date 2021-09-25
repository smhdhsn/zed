<?php

namespace App\Models;

use App\Traits\Authenticatable;
use Zed\Framework\Model;

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
