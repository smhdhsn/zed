<?php

namespace App\Repositories;

use App\Models\User;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class UserRepository
{
    /**
     * Store user into database.
     * 
     * @since 1.0.0
     * 
     * @param array $input
     * 
     * @return object
     */
    public function store(array $input): object
    {
        return User::create($input);
    }

    /**
     * Find user by attribute(s).
     * 
     * @since 1.0.0
     * 
     * @param array $input
     * 
     * @return object
     */
    public function findUser(array $input): object
    {
        return User::where($input)->get();
    }
}
