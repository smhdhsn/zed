<?php

namespace App\Repositories;

use App\Models\User;
use Core\Traits\Repository;

/**
 * @author @smhdhsn
 * 
 * @since 1.2.0
 */
class UserRepository
{
    use Repository;

    /**
     * Storing Model Into Database.
     * 
     * @since 1.2.0
     * 
     * @param array $input
     * 
     * @return array
     */
    public function store(array $input): array
    {
        return $this->model->create($input);
    }
}
