<?php

namespace Core\Traits\Validation;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Maximum
{
    /**
     * Checking If Given Column Is Less Than Maximum Value.
     * 
     * @since 1.0.0
     * 
     * @param string $attribute
     * @param array $rule
     * 
     * @return void
     */
    private function validateMaximum(string $attribute, array $rule): void
    {
        if (strlen($this->{$attribute}) > $rule['max']) {
            $this->addError($attribute, self::RULE_MAX, $rule);
        }
    }
}
