<?php

namespace Core\Traits\Sequel;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Update
{
    /**
     * Updating Model's Information.
     * 
     * @since 1.0.0
     * 
     * @param array $inputs
     * 
     * @return bool
     */
    public function update(array $inputs): bool
    {
        return $this->checkForModelExistance()
            ->makeUpdateQuery($inputs)
            ->prepareDatabase()
            ->updateRecord();
    }

    /**
     * Making Query For Storing Information.
     * 
     * @since 1.0.0
     * 
     * @param array $input
     * 
     * @return object
     */
    private function makeUpdateQuery(array $inputs): object
    {
        $this->inputs = array_merge($this->inputs, $inputs);

        $this->query = "UPDATE \n\t{$this->getTableName()} \nSET" 
        . $this->prepareParams($inputs)
        . "\nWHERE \n\tid=:id;";

        return $this;
    }

    /**
     * Update Database Record With Given Information.
     * 
     * @since 1.0.0
     * 
     * @return bool
     */
    private function updateRecord(): bool
    {
        return $this->statement->execute($this->inputs)
        ? true
        : false;
    }
}
