<?php

namespace Zed\Framework\Validation\Strategy;

use Zed\Framework\Validation\Contract\Validator;
use Zed\Framework\{Application, Validation};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class UniqueValidator implements Validator
{
    /**
     * Database connection.
     * 
     * @since 1.0.1
     * 
     * @var object
     */
    private object $connection;

    /**
     * Validation error.
     * 
     * @since 1.0.1
     * 
     * @var null|string
     */
    private ?string $error = null;

    /**
     * Request inputs.
     * 
     * @since 1.0.1
     * 
     * @var array
     */
    private array $requestInputs;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    public function __construct()
    {
        $this->connection = Application::$database->getConnection();
    }

    /**
     * Set parameters needed to initiate validation.
     * 
     * @since 1.0.1
     * 
     * @param array $requestInputs
     * 
     * @return Validator
     */
    public function setParams(array $requestInputs): Validator
    {
        $this->requestInputs = $requestInputs;

        return $this;
    }

    /**
     * Initiate the validator's validation check.
     * 
     * @since 1.0.1
     * 
     * @param array $validationInformation
     * 
     * @return Validator
     */
    public function validate(array $validationInformation): Validator
    {
        $rule = Validation::getParts($validationInformation['Rule']);

        if ($this->paramExists($validationInformation['attribute'], $rule['unique'][0], $rule['unique'][1])) {
            $this->error = str_replace(
                '{unique}',
                $validationInformation['attribute'], 
                Validation::getErrorMessages(Validation::RULE_UNIQUE)
            );
        }

        return $this;
    }

    /**
     * Get validation error if there are any.
     * 
     * @since 1.0.1
     * 
     * @return null|string
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * Check for existance of a given attribute in a given table.
     * 
     * @since 1.0.1
     * 
     * @param string $attribute
     * @param string $column
     * @param string $table
     * 
     * @return bool
     */
    private function paramExists(string $attribute, string $table, string $column): bool
    {
        $query = "SELECT * FROM \n\t{$table} \nWHERE \n\t{$column}=:{$attribute}";

        $statement = $this->connection->prepare($query);

        $statement->bindParam(":{$attribute}", $this->requestInputs[$attribute]);

        $statement->execute();

        return is_bool($statement->fetchObject())
        ? false
        : true;
    }
}
