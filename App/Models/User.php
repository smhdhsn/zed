<?php

namespace App\Models;

use PDO;
use Core\{Response, Token};
use App\Controllers\BaseController;

/**
 * @author @smhdhsn
 * 
 * @version 1.1.0
 */
class User extends BaseModel
{
    /**
     * Model's Table Name.
     * 
     * @since 1.1.0
     * 
     * @var string
     */
    public $table = 'users';

    /**
     * Database Connection.
     * 
     * @since 1.1.0
     * 
     * @var object
     */
    public $connection;
    
    /**
     * Creates an Instance Of This Class.
     * 
     * @since 1.1.0
     * 
     * @return void
     */
    public function __construct()
    {
        $this->connection = $this->connect();
    }

    /**
     * Logging User In.
     * 
     * @since 1.1.0
     * 
     * @param array $request
     * 
     * @return string
     */
    public function login(array $request)
    {
        $user = $this->findAndVerify($request);

        return (new Token)->generate($user);
    }

    /**
     * Registering User And Returning Access Token.
     * 
     * @since 1.1.0
     * 
     * @param array $request
     * 
     * @return string
     */
    public function register(array $request)
    {
        $user = $this->create($request);

        return (new Token)->generate($user);
    }

    /**
     * Storing User's Info Into Database.
     * 
     * @since 1.1.0
     * 
     * @param array $request
     * 
     * @return array
     */
    public function create(array $request): array
    {
        $query = 'INSERT INTO
                ' . $this->table . '
            SET
                name=:name,
                surname=:surname,
                username=:username,
                email=:email,
                password=:password,
                phone_number=:phone_number';

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($request['name'])));
        $stmt->bindParam(':surname', htmlspecialchars(strip_tags($request['surname'])));
        $stmt->bindParam(':username', htmlspecialchars(strip_tags($request['username'])));
        $stmt->bindParam(':email', htmlspecialchars(strip_tags($request['email'])));
        $stmt->bindParam(':password', htmlspecialchars(strip_tags(password_hash($request['password'], PASSWORD_DEFAULT))));
        $stmt->bindParam(':phone_number', htmlspecialchars(strip_tags($request['phone_number'])));
        $stmt->execute();

        return $this->findByEmail($request);
    }

    /**
     * Getting User's Data Form Database.
     * 
     * @since 1.1.0
     * 
     * @param array $request
     * 
     * @return array
     */
    public function findByEmail(array $request): array
    {
        $query = 'SELECT *
        FROM
            ' . $this->table . '
        WHERE
            email=:email
        LIMIT 0,1';

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', htmlspecialchars(strip_tags($request['email'])));
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Finding User Based On Email|Username And Verifying Their Password.
     * 
     * @since 1.1.0
     * 
     * @param array $request
     * 
     * @return array
     */
    private function findAndVerify(array $request): array
    {
        $query = 'SELECT *
        FROM
            ' . $this->table . '
        WHERE
            email=:username
        OR
            username=:username
        LIMIT 0,1';

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', htmlspecialchars(strip_tags($request['email'])));
        $stmt->bindParam(':username', htmlspecialchars(strip_tags($request['username'])));
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($request['password'], $result['password'])) {
            return $result;
        }
        
        die(
            (new BaseController)->error(
                Response::ERROR,
                'Username Or Password Is Wrong.',
                Response::HTTP_FORBIDDEN
            )
        );
    }
}
