<?php

namespace Core\Traits\Validation;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait MaximumValidation
{
    /**
     * Checking If Given Column Is Less Than Maximum Value.
     * 
     * @since 1.0.0
     * 
     * @param string $requestAttribute
     * @param string $rawRule
     * 
     * @return void
     */
    private function validateMaximum(string $requestAttribute, string $rawRule): void
    {
        $rule = $this->getParts($rawRule);

        if (strlen($this->{$requestAttribute}) > $rule['max']) {
            $this->addError($requestAttribute, self::RULE_MAX, $rule);
        }
    }
}
