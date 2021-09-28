<?php

namespace App\Repositories;

use App\Models\User;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
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
     * @return User
     */
    public function store(array $input): User
    {
        return User::create($input);
    }

    /**
     * Find user by attribute(s).
     * 
     * @since 1.0.1
     * 
     * @param string $column
     * @param string $match
     * 
     * @return User
     */
    public function findUser(string $column, string $match): User
    {
        return User::where($column, $match)->get()[0];
    }
}
