<?php

namespace Core\Traits\Sequel;

use Core\Classes\{BaseController, Response};
use PDOException;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Insert
{
    /**
     * Storing Model Into Database.
     * 
     * @since 1.0.0
     * 
     * @param array $inputs
     * 
     * @return object
     */
    public function create(array $inputs): object
    {
        return self::instantiateClass()
            ->makeCreateQuery($inputs)
            ->prepareDatabase()
            ->createAndFetch();
    }

    /**
     * Making Query For Creating Model.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    private function makeCreateQuery(array $inputs): object
    {
        $this->inputs = $inputs;

        $placeHolders = $this->prepareColumns(':');
        $columns = $this->prepareColumns(null);

        $this->query = "INSERT INTO \n{$this->table}({$columns}\n) \nVALUES({$placeHolders}\n);";

        return $this;
    }

    /**
     * Executing Query And Fetching Data.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    private function createAndFetch(): object
    {
        try {
            if ($this->statement->execute($this->inputs))
                $this->setModelAttributes();

            return $this;
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

    /**
     * Setting Model's Attributes.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function setModelAttributes(): void
    {
        $this->setLastId();
        $this->setAttributes($this->inputs);
    }
}
