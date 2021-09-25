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
     * @return object
     */
    public function store(array $input): object
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
     * @return object
     */
    public function findUser(string $column, string $match): object
    {
        return User::where($column, $match)->get();
    }
}
