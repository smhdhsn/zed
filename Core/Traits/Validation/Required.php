<?php

namespace Core\Traits\Validation;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Required
{
    /**
     * Checking If Given Column Is Required.
     * 
     * @since 1.0.0
     * 
     * @param string $attribute
     * 
     * @return void
     */
    private function validateRequired(string $attribute): void
    {
        if (! $this->{$attribute}) {
            $this->addError($attribute, self::RULE_REQUIRED);
        }
    }
}
