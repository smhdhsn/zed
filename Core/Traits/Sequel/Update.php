<?php

namespace Core\Traits\Sequel;

/**
 * @author @smhdhsn
 * 
 * @version 1.2.0
 */
trait Update
{
    /**
     * Conditions For Updating a Record.
     * 
     * @since 1.2.0
     * 
     * @var array
     */
    private $condition;

    /**
     * Updating Model's Information.
     * 
     * @since 1.2.0
     * 
     * @param array $input
     * 
     * @return array
     */
    public function update(array $input, array $condition): array
    {
        $this->makeUpdatingQuery($input, $condition)
            ->prepareDatabase()
            ->bindConditionParams()
            ->bindParams()
            ->execute();
        
        return $this->input;
    }

    /**
     * Making Query For Storing Information.
     * 
     * @since 1.2.0
     * 
     * @param array $condition
     * @param array $input
     * 
     * @return object
     */
    private function makeUpdatingQuery(array $input, array $condition): object
    {
        $this->condition = $condition;
        $this->input = $input;

        $this->query = "UPDATE \n\t{$this->table} \nSET";
        foreach ($this->input as $key => $chunk) {
            $this->query .= "\n\t{$key}=:{$key}";
            if(next($this->input)) $this->query .=  ',';
        }

        $this->query .= "\nWHERE";
        foreach ($this->condition as $key => $chunk) {
            $this->query .= "\n\t{$key}=:{$key}";
            if(next($this->condition)) $this->query .=  ',';
        }
        
        return $this;
    }

    /**
     * Binding Input Parameters.
     * 
     * @since 1.2.0
     * 
     * @return object
     */
    private function bindConditionParams(): object
    {
        foreach ($this->condition as $key => $chunk) {
            $this->statement->bindParam(":{$key}", htmlspecialchars(strip_tags($chunk)));
        }

        return $this;
    }
}
