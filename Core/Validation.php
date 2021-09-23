<?php

namespace Zed\Framework;

use Zed\Framework\Validation\Contract\Validator;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class Validation implements Validator
{
    /**
     * Available validation rules.
     * 
     * @since 1.0.1
     * 
     * @var string
     */
    CONST RULE_REQUIRED = 'required';
    CONST RULE_NUMERIC = 'numeric';
    CONST RULE_UNIQUE = 'unique';
    CONST RULE_STRING = 'string';
    CONST RULE_EMAIL = 'email';
    CONST RULE_MAX = 'max';
    CONST RULE_MIN = 'min';

    /**
     * Validation strategy's instance.
     * 
     * @since 1.0.1
     * 
     * @var Validator
     */
    private Validator $validator;

    /**
     * Set validation strategy.
     * 
     * @since 1.0.1
     * 
     * @param Validator $validator
     * 
     * @return Validation
     */
    public function setStrategy(Validator $validator): Validation
    {
        $this->validator = $validator;

        return $this;
    }

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
        $this->validator->setParams($requestInputs);

        return $this;
    }

    /**
     * Initiate the validator's validation check.
     * 
     * @since 1.0.1
     * 
     * @return Validator
     */
    public function validate(array $validationInformation): Validator
    {
        $this->validator->validate($validationInformation);

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
        return $this->validator->getError();
    }

    /**
     * Validation error messages.
     * 
     * @since 1.0.1
     * 
     * @param string $errorType
     * 
     * @return string
     */
    public static function getErrorMessages(string $errorType): string
    {
        $messages = [
            self::RULE_MAX => 'Maximum length of this field must be less than {max} characters.',
            self::RULE_MIN => 'Minimum length of this field must be more than {min} characters.',
            self::RULE_UNIQUE => 'Given {unique} already exists in database.',
            self::RULE_EMAIL => 'This field must be valid email address.',
            self::RULE_NUMERIC => 'This field must be numeric.',
            self::RULE_STRING => 'This field must be string.',
            self::RULE_REQUIRED => 'This field is required.',
        ];

        return $messages[$errorType];
    }

    /**
     * Splits rule syntax into parts that can be used by validation section.
     * 
     * @since 1.0.1
     * 
     * @param string $rawRule
     * 
     * @return array
     */
    public static function getParts(string $rawRule): array
    {
        $rule = explode(':', $rawRule);

        return [
            $rule[0] => strpos($rule[1], ',') ? explode(',', $rule[1]) : $rule[1]
        ];
    }
}
