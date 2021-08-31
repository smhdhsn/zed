<?php

namespace Core\Traits\Validation;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait MinimumValidation
{
    /**
     * Checking If Given Column Has The Minimum Value.
     * 
     * @since 1.0.0
     * 
     * @param string $requestAttribute
     * @param string $rawRule
     * 
     * @return void
     */
    private function validateMinimum(string $requestAttribute, string $rawRule): void
    {
        $rule = $this->getParts($rawRule);

        if (strlen($this->{$requestAttribute}) < $rule['min']) {
            $this->addError($requestAttribute, self::RULE_MIN, $rule);
        }
    }
}
