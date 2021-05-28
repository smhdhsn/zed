<?php

namespace App\Services\User;

use App\Models\User;
use Core\Traits\Service;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class UserCreatingService
{
    use Service;

    /**
     * Storing User Into Database.
     * 
     * @since 1.0.0
     * 
     * @param array $request
     * 
     * @return string
     */
    public function register(array $request): string
    {
        $user = $this->repository->store($this->prepareInput($request));

        return $user->login();
    }

    /**
     * Preparing Data For Storing User Into Database.
     * 
     * @since 1.0.0
     * 
     * @param array $request
     * 
     * @return array
     */
    private function prepareInput(array $request): array
    {
        return [
            'name' => $request['name'],
            'surname' => $request['surname'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => password_hash($request['password'], PASSWORD_DEFAULT),
            'phone_number' => $request['phone_number']
        ];
    }
}
