<?php

namespace Core\Traits\Sequel;

use PDO;
use Core\Classes\{BaseController, Response};

/**
 * @author @smhdhsn
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
            ->makeFindQuery($id)
            ->prepareDatabase()
            ->bindParams()
            ->findAndFetch();
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
    private function makeFindQuery(int $id): object
    {
        $this->inputs = ['id' => $id];

        $this->query = "SELECT * FROM \n\t{$this->table} \nWHERE \n\tid=:id";

        return $this;
    }

    /**
     * Executing Statement And Fetching The Results.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    private function findAndFetch(): object
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
