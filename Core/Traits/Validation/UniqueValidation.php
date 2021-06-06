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
        if (false) {
            $this->addError($attribute, self::RULE_UNIQUE, $rule);
        }
    }
}
