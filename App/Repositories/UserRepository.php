<?php

namespace App\Repositories;

use App\Models\User;

/**
 * @author @smhdhsn
 * 
 * @since 1.2.0
 */
class UserRepository
{
    /**
     * Storing Model Into Database.
     * 
     * @since 1.2.0
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
     * Finding User By Chosen Attributes.
     * 
     * @since 1.2.1
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
