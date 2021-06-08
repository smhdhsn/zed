<?php

namespace App\Services\User;

use App\Models\User;
use Core\Traits\Service\RelatedRepository;
use Core\Classes\{BaseController, Request, Response};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class UserFetchingService
{
    use RelatedRepository;

    /**
     * Logging User In.
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
     * Unauthorized Action.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function abort(): void
    {
        die(
            (new BaseController)->error(
                Response::ERROR,
                'Username Or Password Is Wrong.',
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
