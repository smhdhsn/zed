<?php

namespace Core\Traits\Sequel;

/**
 * @author @smhdhsn
 * 
 * @version 1.2.0
 */
trait Insert
{
    /**
     * Storing Model's Info Into Database.
     * 
     * @since 1.2.0
     * 
     * @param array $input
     * 
     * @return array
     */
    public function create(array $input): array
    {
        $this->makeCreatingQuery($input)
            ->prepareDatabase()
            ->bindParams()
            ->execute();
        
        return $this->input;
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
    private function makeCreatingQuery(array $input): object
    {
        $this->input = $input;

        $this->query = "INSERT INTO \n\t{$this->table} \nSET";

        foreach ($this->input as $key => $chunk) {
            $this->query .= "\n\t{$key}=:{$key}";
            if(next($this->input)) $this->query .=  ',';
        }

        return $this;
    }
}
