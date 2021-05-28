<?php

namespace Core\Traits\Sequel;

use PDO;

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
        $this->statement->execute();

        $this->setAttributes($this->statement->fetch(PDO::FETCH_ASSOC));

        return $this->model;
    }
}
