<?php

namespace Core\Traits\Sequel;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Where
{
    /**
     * Finding a Record In Database By Their ID.
     * 
     * @since 1.0.0
     * 
     * @param array $inputs
     * 
     * @return object
     */
    public function where(array $inputs): object
    {
        return self::instantiateClass()
            ->makeWhereQuery($inputs)
            ->prepareDatabase()
            ->bindParams();
    }

    /**
     * Making Query Fo Where Clause.
     * 
     * @since 1.0.0
     * 
     * @param array $inputs
     * 
     * @return object
     */
    private function makeWhereQuery(array $inputs): object
    {
        $this->inputs = $inputs;

        $this->query = "SELECT * FROM \n\t{$this->table} \nWHERE" 
        . $this->prepareSqlParams($inputs);

        return $this;
    }
}
