<?php

namespace Core\Traits\Validation;

/**
 * @author @smhdhsn
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
     * @param string $attribute
     * @param array $rule
     * 
     * @return void
     */
    private function validateUnique(string $attribute, array $rule): void
    {
        if ($this->paramExists($attribute, $rule['unique'])) {
            $rule['unique'] = $attribute;
            $this->addError($attribute, self::RULE_UNIQUE, $rule);
        }
    }

    /**
     * Checking Existance Of Given Attribute In Given Table.
     * 
     * @since 1.0.0
     * 
     * @param string $attribute
     * @param string $table
     * 
     * @return bool
     */
    private function paramExists(string $attribute, string $table): bool
    {
        $query = "SELECT * FROM \n\t{$table} \nWHERE \n\t{$attribute}=:{$attribute}";

        $statement = $this->connect()->prepare($query);
        
        $statement->bindParam(":{$attribute}", $this->{$attribute});
        
        $statement->execute();

        return is_bool($statement->fetchObject())
        ? false
        : true;
    }
}
