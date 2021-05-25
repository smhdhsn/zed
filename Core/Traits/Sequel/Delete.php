<?php

namespace Core\Traits\Sequel;

/**
 * @author @smhdhsn
 * 
 * @version 1.2.0
 */
trait Delete
{
    /**
     * Deleting Model From Database.
     * 
     * @since 1.2.0
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function delete(array $input): bool
    {
        $this->makeDeletingQuery($input)
            ->prepareDatabase()
            ->bindDeletingParams()
            ->execute();
        
        return true;
    }

    /**
     * Making Query For Storing Information.
     * 
     * @since 1.2.0
     * 
     * @param array $input
     * 
     * @return object
     */
    private function makeDeletingQuery(array $input): object
    {
        $this->input = $input;

        $this->query = "DELETE FROM \n\t{$this->table} \nWHERE \n\tid=:id";

        return $this;
    }

    /**
     * Binding Parameters.
     * 
     * @since 1.2.0
     * 
     * @return object
     */
    private function bindDeletingParams(): object
    {
        $this->statement->bindParam(":id", htmlspecialchars(strip_tags($this->input['id'])));

        return $this->statement;
    }
}
