<?php

namespace Zed\Framework\Traits\Sequel;

use Zed\Framework\{Controller, Response};
use PDOException;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
trait Find
{
    /**
     * Finding a Record In Database By Their ID.
     * 
     * @since 1.0.0
     * 
     * @param int $id
     * 
     * @return object
     */
    public function find(int $id): object
    {
        return self::instantiateClass()
            ->makeFindQuery()
            ->prepareDatabase()
            ->findAndFetch($id);
    }

    /**
     * Making Query For Finding Model's Record In Database.
     * 
     * @since 1.0.0
     * 
     * @param int $id
     * 
     * @return object
     */
    private function makeFindQuery(): object
    {
        $this->query = "SELECT * FROM \n\t{$this->getTableName()} \nWHERE \n\tid=:id";

        return $this;
    }

    /**
     * Executing Statement And Fetching The Results.
     * 
     * @since 1.0.0
     * 
     * @param int $id
     * 
     * @return object
     */
    private function findAndFetch(int $id): object
    {
        try {
            if ($this->statement->execute(['id' => $id])) {
                if (is_bool($data = $this->statement->fetchObject(static::class)))
                    die(
                        (new Controller)->error(
                            Response::ERROR,
                            'Not Found!',
                            Response::HTTP_NOT_FOUND
                        )
                    );

                return $data;
            }
        } catch (PDOException $e) {
            die(
                (new Controller)->error(
                    Response::ERROR,
                    $e->getMessage(),
                    Response::HTTP_BAD_REQUEST
                )
            );
        }
    }
}
