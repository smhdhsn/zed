<?php

namespace Core\Traits\Validation;

/**
 * @author @SMhdHsn
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
            $this->addError(self::RULE_STRING, $requestAttribute);
        }
    }
}
