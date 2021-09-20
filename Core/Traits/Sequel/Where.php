<?php

namespace Core\Traits\Sequel;

/**
 * @author @SMhdHsn
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
            ->prepareDatabase();
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

        $this->query = "SELECT * FROM \n\t{$this->getTableName()} \nWHERE" 
        . $this->prepareParams($inputs);

        return $this;
    }
}
