<?php

namespace Core\Traits\Validation;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
trait UniqueValidation
{
    /**
     * Checking If Given Column Is Unique.
     * 
     * @since 1.0.0
     * 
     * @param string $requestAttribute
     * @param string $rawRule
     * 
     * @return void
     */
    private function validateUnique(string $requestAttribute, string $rawRule): void
    {
        $rule = $this->getParts($rawRule);

        if ($this->paramExists($requestAttribute, $rule['unique'][0], $rule['unique'][1])) {
            $rule['unique'] = $requestAttribute;
            $this->addError(self::RULE_UNIQUE, $requestAttribute, $rule);
        }
    }

    /**
     * Checking Existance Of Given Attribute In Given Table.
     * 
     * @since 1.0.0
     * 
     * @param string $requestAttribute
     * @param string $column
     * @param string $table
     * 
     * @return bool
     */
    private function paramExists(string $requestAttribute, string $table, string $column): bool
    {
        $query = "SELECT * FROM \n\t{$table} \nWHERE \n\t{$column}=:{$requestAttribute}";

        $statement = $this->connect()->prepare($query);
        
        $statement->bindParam(":{$requestAttribute}", $this->{$requestAttribute});
        
        $statement->execute();

        return is_bool($statement->fetchObject())
        ? false
        : true;
    }
}
