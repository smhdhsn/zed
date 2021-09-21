<?php

namespace App\Services\User;

use Zed\Framework\{Controller, Request, Response};
use App\Repositories\UserRepository;
use App\Models\User;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class UserFetchingService
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
     * Login user.
     * 
     * @since 1.0.0
     * 
     * @param Request $request
     * 
     * @return string
     */
    public function login(Request $request): string
    {
        $user = $this->repository->findUser($this->prepareInput($request));
        $result = $this->verifyPassword($user, $request);

        return $result ? $user->login() : $this->abort();
    }

    /**
     * Unauthorized action.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function abort(): void
    {
        die(
            (new Controller)->error(
                Response::ERROR,
                'Username or password is wrong.',
                Response::HTTP_FORBIDDEN
            )
        );
    }

    /**
     * Verifying Input Password With Fetched User's Password.
     * 
     * @since 1.0.0
     * 
     * @param Request $request
     * @param User $user
     * 
     * @return bool
     */
    private function verifyPassword(User $user, Request $request): bool
    {
        return password_verify($request->password, $user->password);
    }

    /**
     * Preparing Input For Fetching User From Database.
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
            'email' => $request->email
        ];
    }
}
