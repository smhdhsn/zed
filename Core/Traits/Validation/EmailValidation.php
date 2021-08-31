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
     * @param string $requestAttribute
     * 
     * @return void
     */
    private function validateEmail(string $requestAttribute): void
    {
        if (! filter_var($this->{$requestAttribute}, FILTER_VALIDATE_EMAIL)) {
            $this->addError($requestAttribute, self::RULE_EMAIL);
        }
    }
}
