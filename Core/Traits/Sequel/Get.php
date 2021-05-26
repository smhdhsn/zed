<?php

namespace Core\Traits\Sequel;

use PDO;
use PDOException;
use Core\Classes\{BaseController, Response};

/**
 * @author @smhdhsn
 * 
 * @version 1.2.1
 */
trait Get
{
    /**
     * Executing Query.
     * 
     * @since 1.2.1
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
     * @since 1.2.1
     * 
     * @return object
     */
    private function getAndFetch(): object
    {
        try {
            if ($this->statement->execute()) {
                if (! is_bool($data = $this->statement->fetch(PDO::FETCH_ASSOC)))
                    $this->setAttributes($data);
                else
                    die(
                        (new BaseController)->error(
                            Response::ERROR,
                            'Not Found !',
                            Response::HTTP_NOT_FOUND
                        )
                    );
            }

            return $this->model;
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
