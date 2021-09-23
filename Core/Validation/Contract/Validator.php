<?php

namespace Zed\Framework\Validation\Contract;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
interface Validator
{
    /**
     * Set parameters needed to initiate validation.
     * 
     * @since 1.0.1
     * 
     * @param array $requestInputs
     * 
     * @return Validator
     */
    public function setParams(array $requestInputs): Validator;

    /**
     * Initiate the validator's validation check.
     * 
     * @since 1.0.1
     * 
     * @param array $validationInformation
     * 
     * @return Validator
     */
    public function validate(array $validationInformation): Validator;

    /**
     * Get validation error if there are any.
     * 
     * @since 1.0.1
     * 
     * @return null|string
     */
    public function getError(): ?string;
}
