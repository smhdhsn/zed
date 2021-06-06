<?php

namespace Core\Traits\Validation;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait StringValidation
{
    /**
     * Checking If Given Column Is String.
     * 
     * @since 1.0.0
     * 
     * @param string $attribute
     * 
     * @return void
     */
    private function validateString(string $attribute): void
    {
        if (! is_string($this->{$attribute})) {
            $this->addError($attribute, self::RULE_STRING);
        }
    }
}
