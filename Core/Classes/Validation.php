<?php

namespace Core\Classes;

use Core\Classes\{BaseController, Database, Response};
use Core\Traits\Validation\{RequiredValidation, MaximumValidation, MinimumValidation, NumericValidation, StringValidation, UniqueValidation, EmailValidation};

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
        foreach ($validationRules as $attribute => $rules) {
            foreach ($rules as $rule) {
                $ruleName = is_array($rule) ? array_search(reset($rule), $rule) : $rule;

                switch ($ruleName) {
                    case self::RULE_MAX:
                        $this->validateMaximum($attribute, $rule);
                    break;
                    case self::RULE_MIN:
                        $this->validateMinimum($attribute, $rule);
                    break;
                    case self::RULE_UNIQUE:
                        $this->validateUnique($attribute, $rule);
                    break;
                    case self::RULE_REQUIRED:
                        $this->validateRequired($attribute);
                    break;
                    case self::RULE_NUMERIC:
                        $this->validateNumeric($attribute);
                    break;
                    case self::RULE_STRING:
                        $this->validateString($attribute);
                    break;
                    case self::RULE_EMAIL:
                        $this->validateEmail($attribute);
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
    private function addError(string $attribute, string $rule, ?array $params = [])
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
