<?php

namespace Core\Traits\Validation;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait NumericValidation
{
    /**
     * Checking If Given Column Is Numeric.
     * 
     * @since 1.0.0
     * 
     * @param string $attribute
     * 
     * @return void
     */
    private function validateNumeric(string $attribute): void
    {
        if (! is_numeric($this->{$attribute})) {
            $this->addError($attribute, self::RULE_NUMERIC);
        }
    }
}
