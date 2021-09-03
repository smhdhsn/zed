<?php

namespace Core\Classes;

use Core\Traits\Validation\{RequiredValidation, MaximumValidation, MinimumValidation, NumericValidation, StringValidation, UniqueValidation, EmailValidation};
use Core\Classes\{BaseController, Database, Response};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class Validation extends Database
{
    use RequiredValidation, MaximumValidation, MinimumValidation, NumericValidation, StringValidation, UniqueValidation, EmailValidation;

    /**
     * Validation Errors.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    private array $errors = [];

    /**
     * Available Rules.
     * 
     * @since 1.0.0
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
     * Validating Request Prameters.
     * 
     * @since 1.0.0
     * 
     * @param array $validationRules
     * 
     * @return object
     */
    public function validate(array $validationRules): object
    {
        foreach ($validationRules as $requestAttribute => $rules) {
            foreach (explode('|', $rules) as $rule) {
                
                $ruleName = explode(':', $rule)[0] ?? $rule;

                switch ($ruleName) {
                    case self::RULE_MAX:
                        $this->validateMaximum($requestAttribute, $rule);
                    break;
                    case self::RULE_MIN:
                        $this->validateMinimum($requestAttribute, $rule);
                    break;
                    case self::RULE_UNIQUE:
                        $this->validateUnique($requestAttribute, $rule);
                    break;
                    case self::RULE_REQUIRED:
                        $this->validateRequired($requestAttribute);
                    break;
                    case self::RULE_NUMERIC:
                        $this->validateNumeric($requestAttribute);
                    break;
                    case self::RULE_STRING:
                        $this->validateString($requestAttribute);
                    break;
                    case self::RULE_EMAIL:
                        $this->validateEmail($requestAttribute);
                    break;
                }
            }
        }
        
        return empty($this->errors)
        ? $this
        : $this->abort();
    }

    /**
     * Recording Validation Errors.
     * 
     * @since 1.0.0
     * 
     * @param array|null $params
     * @param string $attribute
     * @param string $rule
     * 
     * @return void
     */
    private function addError(string $attribute, string $rule, ?array $params = []): void
    {
        $message = $this->messages()[$rule];

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }
    
    /**
     * Validation Error Messages.
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    private function messages(): array
    {
        return [
            self::RULE_REQUIRED => 'This Field Is Required.',
            self::RULE_STRING => 'This Field Must Be String.',
            self::RULE_NUMERIC => 'This Field Must Be Numeric.',
            self::RULE_EMAIL => 'This Field Must Be Valid Email Address.',
            self::RULE_UNIQUE => 'Given {unique} Already Exists In Database.',
            self::RULE_MIN => 'Minimum Length Of This Field Must Be More Than {min} Characters.',
            self::RULE_MAX => 'Maximum Length Of This Field Must Be Less Than {max} Characters.',
        ];
    }

    /**
     * Splits Rule Syntax Into Parts That Can Be Used By Validation Section.
     * 
     * @since 1.0.0
     * 
     * @param string $rawRule
     * 
     * @return array
     */
    private function getParts(string $rawRule): array
    {
        $rule = explode(':', $rawRule);

        return [
            $rule[0] => strpos($rule[1], ',') ? explode(',', $rule[1]) : $rule[1]
        ];
    }

    /**
     * In Case The Validation Has Errors.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function abort(): void
    {
        die(
            (new BaseController)->error(
                Response::ERROR,
                $this->errors,
                Response::HTTP_MISDIRECTED_REQUEST
            )
        );
    }
}
