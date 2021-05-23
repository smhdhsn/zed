<?php

namespace Core\Traits\Eloquent;

use PDO;

/**
 * @author @smhdhsn
 * 
 * @version 1.2.0
 */
trait Where
{
    /**
     * Finding User By Username|Email.
     * 
     * @since 1.2.0
     * 
     * @param array $input
     * 
     * @return array
     */
    public function where(array ...$input): array
    {
        $this->makeWhereClauseQuery($input)
            ->prepareDatabase()
            ->bindWhereClauseParams()
            ->execute();

        return $this->statement->fetch(PDO::FETCH_ASSOC);
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
    private function makeWhereClauseQuery(array $input): object
    {
        $this->input = $input;

        $this->query = "SELECT * FROM \n\t{$this->table} \nWHERE";

        foreach ($this->input as $inputs) {
            foreach ($inputs as $key => $chunk) {
                $this->query .= "\n\t{$key}=:{$key}";
                $this->query .= next($this->input) ? "\nAND" : ';';
            }
        }

        return $this;
    }

    /**
     * Binding Parameters.
     * 
     * @since 1.2.0
     * 
     * @return object
     */
    private function bindWhereClauseParams(): object
    {
        foreach ($this->input as $inputs) {
            foreach ($inputs as $key => $chunk) {
                $this->statement->bindParam(":{$key}", htmlspecialchars(strip_tags($chunk)));
            }
        }

        return $this->statement;
    }
}
