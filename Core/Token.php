<?php

namespace Zed\Framework;

use App\Models\User;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
final class Token
{
    /**
     * Token key.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    private string $key;

    /**
     * Expiration time.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    private string $expirationTime;
    
    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct()
    {
        $this->expirationTime = $_ENV['TOKEN_EXPIRATION_TIME'];
        $this->key = $_ENV['TOKEN_KEY'];
    }

    /**
     * Verify access token.
     * 
     * @since 1.0.0
     * 
     * @return bool
     */
    public function verify(): bool
    {
        $token = apache_request_headers()['Authorization'];
        $decoded = $this->decode($token);
        $diff = strtotime(date("Y-m-d H:i:s")) - strtotime($decoded->created_at);

        return $diff < $this->expirationTime 
            && $decoded->key === $this->key
            ?  true
            :  false;
    }

    /**
     * Generate JWT token.
     * 
     * @since 1.0.0
     * 
     * @param User $user
     * 
     * @return string
     */
    public function generate(User $user): string
    {
        $header = base64_encode(
            json_encode([
                'typ' => 'JWT',
                'alg' => 'HS256'
            ])
        );

        $payload = base64_encode(
            json_encode([
                'id' => $user->id,
                'key' => $this->key,
                'email' => $user->email,
                'username' => $user->username,
                'created_at' => date("Y-m-d H:i:s"),
            ])
        );

        $signature = base64_encode(
            hash_hmac(
                'sha256',
                "{$header}.{$payload}",
                $this->key,
                true
            )
        );

        return "{$header}.{$payload}.{$signature}";
    }

    /**
     * Decode access token.
     * 
     * @since 1.0.0
     * 
     * @param string|null $token
     * 
     * @return object|null
     */
    public function decode(?string $token): ?object
    {
        $tokenParts = explode(".", $token);
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);

        return $jwtPayload;
    }
}
