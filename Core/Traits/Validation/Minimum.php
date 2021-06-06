<?php

namespace Core\Traits\Validation;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Minimum
{
    /**
     * Checking If Given Column Has The Minimum Value.
     * 
     * @since 1.0.0
     * 
     * @param string $attribute
     * @param array $rule
     * 
     * @return void
     */
    private function validateMinimum(string $attribute, array $rule): void
    {
        if (strlen($this->{$attribute}) < $rule['min']) {
            $this->addError($attribute, self::RULE_MIN, $rule);
        }
    }
}
