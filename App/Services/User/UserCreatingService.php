<?php

namespace App\Services\User;

use App\Models\User;
use Core\Classes\Request;
use Core\Traits\Service\RelatedRepository;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class UserCreatingService
{
    use RelatedRepository;

    /**
     * Storing User Into Database.
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
     * Preparing Data For Storing User Into Database.
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
