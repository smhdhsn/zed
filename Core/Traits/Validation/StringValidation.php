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
     * @param string $requestAttribute
     * 
     * @return void
     */
    private function validateString(string $requestAttribute): void
    {
        if (! is_string($this->{$requestAttribute})) {
            $this->addError($requestAttribute, self::RULE_STRING);
        }
    }
}
