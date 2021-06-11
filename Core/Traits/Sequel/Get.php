<?php

namespace Core\Traits\Sequel;

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
            if ($this->statement->execute($this->inputs)) {
                if (is_bool($data = $this->statement->fetchObject(static::class)))
                    die(
                        (new BaseController)->error(
                            Response::ERROR,
                            'Not Found !',
                            Response::HTTP_NOT_FOUND
                        )
                    );

                return $data;
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
