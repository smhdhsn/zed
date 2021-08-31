<?php

namespace Core\Traits\Validation;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait RequiredValidation
{
    /**
     * Checking If Given Column Is Required.
     * 
     * @since 1.0.0
     * 
     * @param string $requestAttribute
     * 
     * @return void
     */
    private function validateRequired(string $requestAttribute): void
    {
        if (! $this->{$requestAttribute}) {
            $this->addError($requestAttribute, self::RULE_REQUIRED);
        }
    }
}
