<?php

namespace Core\Traits\Sequel;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
trait Delete
{
    /**
     * Deleting a Model's Record From Database.
     * 
     * @since 1.0.0
     * 
     * @return bool
     */
    public function delete(): bool
    {
        return $this->checkForModelExistance()
            ->makeDeleteQuery()
            ->prepareDatabase()
            ->destroyRecord();
    }

    /**
     * Making Query For Finding Model's Record In Database.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    private function makeDeleteQuery(): object
    {
        $this->query = "DELETE FROM \n\t{$this->getTableName()} \nWHERE \n\tid=:id";

        return $this;
    }

    /**
     * Executing Statement And Returning The Result.
     * 
     * @since 1.0.0
     * 
     * @return bool
     */
    private function destroyRecord(): bool
    {
        return $this->statement->execute($this->inputs)
        ? true
        : false;
    }
}
