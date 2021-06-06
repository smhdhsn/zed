<?php

namespace Core\Traits\Validation;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait EmailValidation
{
    /**
     * Checking If Given Column Is a Valid Email.
     * 
     * @since 1.0.0
     * 
     * @param string $attribute
     * 
     * @return void
     */
    private function validateEmail(string $attribute): void
    {
        if (! filter_var($this->{$attribute}, FILTER_VALIDATE_EMAIL)) {
            $this->addError($attribute, self::RULE_EMAIL);
        }
    }
}
