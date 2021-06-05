<?php

namespace Core\Traits\Sequel;

use PDO;
use PDOException;
use Core\Classes\{BaseController, Response};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Get
{
    /**
     * Executing Query.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    public function get(): object
    {
        return $this->getAndFetch();
    }

    /**
     * Executing Query And Fetching Results.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    private function getAndFetch(): object
    {
        try {
            if ($this->statement->execute()) {
                if (is_object($data = $this->statement->fetchObject(static::class)))
                    return $data;
                else
                    die(
                        (new BaseController)->error(
                            Response::ERROR,
                            'Not Found !',
                            Response::HTTP_NOT_FOUND
                        )
                    );
            }
        } catch (PDOException $e) {
            die(
                (new BaseController)->error(
                    Response::ERROR,
                    $e->getMessage(),
                    Response::HTTP_BAD_REQUEST
                )
            );
        }
    }
}
