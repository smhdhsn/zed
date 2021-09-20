<?php

namespace App\Services\User;

use App\Repositories\UserRepository;
use Core\Classes\Request;
use App\Models\User;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class UserCreatingService
{
    /**
     * Model's repository.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    private object $repository;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct()
    {
        $this->repository = new UserRepository;
    }

    /**
     * Store user into database.
     * 
     * @since 1.0.0
     * 
     * @param Request $request
     * 
     * @return string
     */
    public function register(Request $request): string
    {
        $user = $this->repository->store($this->prepareInput($request));

        return $user->login();
    }

    /**
     * Prepare data for storing user.
     * 
     * @since 1.0.0
     * 
     * @param Request $request
     * 
     * @return array
     */
    private function prepareInput(Request $request): array
    {
        return [
            'name' => $request->name,
            'surname' => $request->surname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
            'phone_number' => $request->phone_number
        ];
    }
}
