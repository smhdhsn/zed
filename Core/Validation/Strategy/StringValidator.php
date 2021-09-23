<?php

namespace Zed\Framework\Validation\Strategy;

use Zed\Framework\Validation\Contract\Validator;
use Zed\Framework\Validation;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class StringValidator implements Validator
{
    /**
     * Validation error.
     * 
     * @since 1.0.1
     * 
     * @var null|string
     */
    private ?string $error = null;

    /**
     * Request inputs.
     * 
     * @since 1.0.1
     * 
     * @var array
     */
    private array $requestInputs;

    /**
     * Set parameters needed to initiate validation.
     * 
     * @since 1.0.1
     * 
     * @param array $requestInputs
     * 
     * @return Validator
     */
    public function setParams(array $requestInputs): Validator
    {
        $this->requestInputs = $requestInputs;

        return $this;
    }

    /**
     * Initiate the validator's validation check.
     * 
     * @since 1.0.1
     * 
     * @param array $validationInformation
     * 
     * @return Validator
     */
    public function validate(array $validationInformation): Validator
    {
        if (! is_string($this->requestInputs[$validationInformation['attribute']])) {
            $this->error = Validation::getErrorMessages(Validation::RULE_STRING);
        }

        return $this;
    }

    /**
     * Get validation error if there are any.
     * 
     * @since 1.0.1
     * 
     * @return null|string
     */
    public function getError(): ?string
    {
        return $this->error;
    }
}
