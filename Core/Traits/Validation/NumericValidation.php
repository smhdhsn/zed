<?php

namespace Core\Traits\Validation;

/**
 * @author @SMhdHsn
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
     * @param string $requestAttribute
     * 
     * @return void
     */
    private function validateNumeric(string $requestAttribute): void
    {
        if (! is_numeric($this->{$requestAttribute})) {
            $this->addError(self::RULE_NUMERIC, $requestAttribute);
        }
    }
}
